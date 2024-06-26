<?php
/**
 * Envira Gallery Rest Class.
 *
 * @since 1.8.5
 *
 * @package Envira Gallery
 * @author  Envira Gallery Team <support@enviragallery.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Envira Rest Class
 */
class Envira_Rest {

	/**
	 * Singleton Var
	 *
	 * @var object
	 */
	public static $instance = null;

	/**
	 * Base Object
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Envira Common Object
	 *
	 * @var object
	 */
	public $common;
	/**
	 * Class Constructor
	 *
	 * @since 1.8.5
	 */
	public function __construct() {

		// Load the base class object.
		$this->base   = Envira_Gallery_Lite::get_instance();
		$this->common = Envira_Gallery_Common::get_instance();

		add_action( 'rest_api_init', [ $this, 'register_post_meta' ] );
	}

	/**
	 * Helper Method to register Envira gallery Meta
	 *
	 * @since 1.8.5
	 *
	 * @return void
	 */
	public function register_post_meta() {

		register_rest_field(
			'envira',
			'gallery_data',
			[
				'get_callback'    => [ $this, 'get_gallery_data' ],
				'update_callback' => [ $this, 'update_gallery_data' ],
			]
		);
	}

	/**
	 * Rest API callback to get gallery data.
	 *
	 * @param [type] $object_data Post Object.
	 * @param [type] $field_name Rest Field Name.
	 * @param [type] $request Rest Request.
	 * @return array
	 */
	public function get_gallery_data( $object_data, $field_name, $request ) {

		$data = get_post_meta( $object_data['id'], '_eg_gallery_data', true );

		if ( ! is_array( $data ) ) {
			$data = [];
		}

		$i      = 0;
		$images = [];
		$url    = false;

		if ( isset( $data['gallery'] ) && is_array( $data['gallery'] ) ) {
			foreach ( $data['gallery'] as $id => $item ) {

				// Skip over images that are pending (ignore if in Preview mode).
				if ( isset( $item['status'] ) && 'pending' === $item['status'] && ! is_preview() ) {
					continue;
				}

				$width    = null;
				$height   = null;
				$imagesrc = $this->get_image_src( $id, $item, $data, false, false );

				// Get the image file path.
				$urlinfo       = wp_parse_url( $imagesrc );
				$wp_upload_dir = wp_upload_dir();

				// Interpret the file path of the image.
				if ( preg_match( '/\/[0-9]{4}\/[0-9]{2}\/.+$/', $urlinfo['path'], $matches ) ) {

					$file_path = $wp_upload_dir['basedir'] . $matches[0];

				} else {

					$content_dir = defined( 'WP_CONTENT_DIR' ) ? WP_CONTENT_DIR : '/wp-content/';
					$uploads_dir = is_multisite() ? '/files/' : $content_dir;
					$file_path   = trailingslashit( $wp_upload_dir['basedir'] ) . basename( $urlinfo['path'] );
					$file_path   = preg_replace( '/(\/\/)/', '/', $file_path );

				}

				if ( file_exists( $file_path ) && is_file( $file_path ) ) { // file_exists checks for file/directory, is_file can be an extra check.
					list( $width, $height ) = getimagesize( $file_path );
				}

				$item['src']    = $imagesrc;
				$item['id']     = $id;
				$item['height'] = intval( $height );
				$item['width']  = intval( $width );
				$images[ $i ]   = $item;

				++$i;
			}
			$data['gallery'] = $images;

		}

		if ( ! isset( $data['config'] ) || ! is_array( $data['config'] ) ) {
			$data['config'] = [];
		}

		$data['config']['title'] = wp_strip_all_tags( get_the_title( $object_data['id'] ) );

		// Allow the data to be filtered before it is stored and used to create the gallery output.
		$data = apply_filters( 'envira_gallery_pre_data', $data, $object_data['id'] );

		return $data;
	}

	/**
	 * Rest API updater callback.
	 *
	 * @since 1.8.5
	 *
	 * @param array  $value Value to update.
	 * @param object $post_object Post Object.
	 * @param string $field_name Meta field name.
	 *
	 * @return array
	 */
	public function update_gallery_data( $value, $post_object, $field_name ) {

		$gallery_data = get_post_meta( $post_object->ID, '_eg_gallery_data', true );

		// If Gallery Data is emptyy prepare it.
		if ( ! is_array( $gallery_data ) ) {
			$gallery_data = [];
		}

		if ( empty( $gallery_data['config'] ) ) {
			$gallery_data['config'] = [];

			$common = new Envira_Gallery_Common();
			// Loop through the defaults and prepare them to be stored.
			$defaults = $common->get_config_defaults( $post_object->ID );

			foreach ( $defaults as $key => $default ) {

				$gallery_data['config'][ $key ] = $default;

			}
		}

		// Update Fields.
		$gallery_data['id']              = $post_object->ID;
		$gallery_data['config']['title'] = $post_object->title;

		if ( isset( $value['config'] ) ) {
			$gallery_data['config'] = wp_parse_args( $value['config'], $gallery_data['config'] );
		}

		if ( isset( $value['remove_image'] ) ) {
			$in_gallery  = get_post_meta( $post_object->ID, '_eg_in_gallery', true );
			$has_gallery = get_post_meta( $value['attach_id'], '_eg_has_gallery', true );

			// Unset the image from the gallery, in_gallery and has_gallery checkers.
			unset( $gallery_data['gallery'][ $value['attach_id'] ] );

			$key = array_search( $value['attach_id'], (array) $in_gallery, true );

			if ( false !== $key ) {
				unset( $in_gallery[ $key ] );
			}

			$has_key = array_search( $post_object->ID, (array) $has_gallery, true );

			if ( false !== $has_key ) {
				unset( $has_gallery[ $has_key ] );
			}
		}

		if ( isset( $value['update_image'] ) ) {

			$attach_id    = $value['attach_id'];
			$update_image = $value['updated_image'];

			if ( isset( $update_image['title'] ) ) {
				$gallery_data['gallery'][ $attach_id ]['title'] = trim( $update_image['title'] );
			}
			if ( isset( $update_image['caption'] ) ) {
				$gallery_data['gallery'][ $attach_id ]['caption'] = trim( $update_image['caption'] );
			}
		}

		if ( isset( $value['gallery'] ) ) {

			foreach ( (array) $value['gallery'] as $i => $image ) {
				$gallery_data = envira_gallery_ajax_prepare_gallery_data( $gallery_data, $image['id'] );
			}
		}

		// Flush gallery cache.
		$this->common->flush_gallery_caches( $post_object->ID );

		return update_post_meta( $post_object->ID, '_eg_gallery_data', $gallery_data );
	}
	/**
	 * Helper method to retrieve the proper image src attribute based on gallery settings.
	 *
	 * @since 1.7.0
	 *
	 * @param int   $id         The image attachment ID to use.
	 * @param array $item       Gallery item data.
	 * @param array $data       The gallery data to use for retrieval.
	 * @param bool  $mobile        Whether or not to retrieve the mobile image.
	 * @param bool  $retina     Whether to return a retina sized image.
	 * @return string               The proper image src attribute for the image.
	 */
	public function get_image_src( $id, $item, $data, $mobile = false, $retina = false ) {

		// Define variable.
		$src = false;

		// Check for mobile and mobile setting.
		$type = $mobile && $this->get_config( 'mobile', $data ) ? 'mobile' : 'crop'; // 'crop' is misleading here - it's the key that stores the thumbnail width + height

		// If this image is an instagram, we grab the src and don't use the $id.
		// otherwise using the $id refers to a postID in the database and has been known.
		// at times to pull up the wrong thumbnail instead of the instagram one.
		$instagram = false;

		if ( ! empty( $item['src'] ) && strpos( $item['src'], 'cdninstagram' ) !== false ) :
			// using 'cdninstagram' because it seems all urls contain it - but be watchful in the future.
			$instagram = true;
			$src       = $item['src'];
			$image     = $item['src'];
		endif;

		$image_size = $this->get_config( 'image_size', $data );

		if ( ! $src && is_int( $id ) ) : // wp_get_attachment_image_src only accepts $id as integer.

			if ( ( $this->get_config( 'crop', $data ) && 'default' === $image_size ) || 'full' === $image_size ) {

				$src = apply_filters( 'envira_gallery_retina_image_src', wp_get_attachment_image_src( $id, 'full' ), $id, $item, $data, $mobile );

			} elseif ( 'full' !== $image_size && ! $retina ) {

				// Check if this Gallery uses a WordPress defined image size.
				if ( 'default' !== $image_size ) {
					// If image size is envira_gallery_random, get a random image size.
					if ( 'envira_gallery_random' === $image_size ) {

						// Get random image sizes that have been chosen for this Gallery.
						$image_sizes_random = (array) $this->get_config( 'image_sizes_random', $data );

						if ( count( $image_sizes_random ) === 0 ) {
							// The user didn't choose any image sizes - use them all.
							$wordpress_image_sizes           = $this->common->get_image_sizes( true );
							$wordpress_image_size_random_key = array_rand( $wordpress_image_sizes, 1 );
							$image_size                      = $wordpress_image_sizes[ $wordpress_image_size_random_key ]['value'];
						} else {
							$wordpress_image_size_random_key = array_rand( $image_sizes_random, 1 );
							$image_size                      = $image_sizes_random[ $wordpress_image_size_random_key ];
						}

						// Get the random WordPress defined image size.
						$src = wp_get_attachment_image_src( $id, $image_size );
					} else {
						// Get the requested WordPress defined image size.
						$src = wp_get_attachment_image_src( $id, $image_size );
					}
				} else {

					$isize = $this->find_clostest_size( $data ) !== '' ? $this->find_clostest_size( $data ) : 'full';
					$src   = apply_filters( 'envira_gallery_default_image_src', wp_get_attachment_image_src( $id, $isize ), $id, $item, $data, $mobile );

				}
			} else {

				$src = apply_filters( 'envira_gallery_retina_image_src', wp_get_attachment_image_src( $id, 'full' ), $id, $item, $data, $mobile );

			}

		endif;

		// Check if this returned an image.
		if ( ! $src ) {
			// Fallback to the $item's image source.
			$image = $item['src'];
		} elseif ( ! $instagram ) {
			$image = $src[0];
		}

		// If we still don't have an image at this point, something went wrong.
		if ( ! isset( $image ) ) {
			return apply_filters( 'envira_gallery_no_image_src', $item['link'], $id, $item, $data );
		}

		// If the current layout is justified/automatic.
		// if the image size is a WordPress size and we're not requesting a retina image we don't need to resize or crop anything.
		if ( 'default' !== $image_size && ! $retina && 'mobile' !== $type ) {
			return apply_filters( 'envira_gallery_image_src', $image, $id, $item, $data );
		}
		$crop = $this->get_config( 'crop', $data );

		if ( $crop || 'mobile' === $type ) {

			// If the image size is default (i.e. the user has input their own custom dimensions in the Gallery),
			// we may need to resize the image now.
			// This is safe to call every time, as resize_image() will check if the image already exists, preventing thumbnails.
			// from being generated every single time.
			$args = [
				'position' => $this->get_config( 'crop_position', $data ),
				'width'    => $this->get_config( $type . '_width', $data ),
				'height'   => $this->get_config( $type . '_height', $data ),
				'quality'  => 100,
				'retina'   => $retina,
			];

			// If we're requesting a retina image, and the gallery uses a registered WordPress image size,
			// we need use the width and height of that registered WordPress image size - not the gallery's
			// image width and height, which are hidden settings.
			// if this is mobile, go with the mobile image settings, otherwise proceed?
			if ( 'default' !== $image_size && $retina && 'mobile' !== $type ) {
				// Find WordPress registered image size.
				$wordpress_image_sizes = $this->common->get_image_sizes( true ); // true = WordPress only image sizes (excludes random.

				foreach ( $wordpress_image_sizes as $size ) {

					if ( $size['value'] !== $image_size ) {
						continue;
					}

					// We found the image size. Use its dimensions.
					if ( ! empty( $size['width'] ) ) {
						$args['width'] = $size['width'];
					}
					if ( ! empty( $size['height'] ) ) {
						$args['height'] = $size['height'];
					}
					break;

				}
			}

			// Filter.
			$args = apply_filters( 'envira_gallery_crop_image_args', $args );

			// Make sure we're grabbing the full image to crop.
			$image_to_crop = apply_filters( 'envira_gallery_crop_image_src', wp_get_attachment_image_src( $id, 'full' ), $id, $item, $data, $mobile );
			// Check if this returned an image.
			if ( ! $image_to_crop ) {
				// Fallback to the $item's image source.
				$image_to_crop = $item['src'];
			} elseif ( ! $instagram ) {
				$image_to_crop = $src[0];
			}

			$resized_image = $this->common->resize_image( $image_to_crop, $args['width'], $args['height'], true, $this->get_config( 'crop_position', $data ), $args['quality'], $args['retina'], $data );

			// If there is an error, possibly output error message and return the default image src.
			if ( is_wp_error( $resized_image ) ) {
				return false;
			} else {

				return apply_filters( 'envira_gallery_image_src', $resized_image, $id, $item, $data );

			}
		}
		// return full image.
		return apply_filters( 'envira_gallery_image_src', $image, $id, $item, $data );
	}

	/**
	 * Helper method for retrieving config values.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The config key to retrieve.
	 * @param array  $data The gallery data to use for retrieval.
	 * @return string     Key value on success, default if not set.
	 */
	public function get_config( $key, $data ) {

		return isset( $data['config'][ $key ] ) ? $data['config'][ $key ] : $this->common->get_config_default( $key );
	}

	/**
	 * Helper Method to find closest size
	 *
	 * @param array $data Gallery Data.
	 * @return mixed
	 */
	public function find_clostest_size( $data ) {

		$image_sizes = $this->common->get_image_sizes();
		$dimensions  = $this->get_config( 'dimensions', $data );
		$width       = $this->get_config( 'crop_width', $data );
		$height      = $this->get_config( 'crop_height', $data );
		$match       = false;

		usort( $image_sizes, [ $this, 'usort_callback' ] );

		foreach ( $image_sizes as $num ) {
			if ( isset( $num['width'] ) && isset( $num['height'] ) ) {
				$num['width']  = (int) $num['width'];
				$num['height'] = (int) $num['height'];

				// skip over sizes that are smaller.
				if ( $num['height'] < $height || $num['width'] < $width ) {
					continue;
				}
				if ( $num['width'] > $width && $num['height'] > $height ) {

					if ( false === $match ) {

						$match = true;
						$size  = $num['name'];

						return $size;
					}
				}
			}
		}
		return '';
	}

	/**
	 * Helper function for usort and php 5.3 >.
	 *
	 * @access public
	 * @param mixed $a First sort.
	 * @param mixed $b Second sort.
	 * @return int
	 */
	public function usort_callback( $a, $b ) {
		if ( isset( $a['width'] ) && isset( $b['width'] ) ) {
			if ( intval( $a['width'] ) === intval( $b['width'] ) ) {
				return 0;
			}

			return intval( $a['width'] ) > intval( $b['width'] ) ? 1 : -1;
		}

		return 0;
	}
	/**
	 * Maybe sort the gallery images, if specified in the config
	 *
	 * Note: To ensure backward compat with the previous 'random' config
	 * key, the sorting parameter is still stored in the 'random' config
	 * key.
	 *
	 * @since 1.3.8
	 *
	 * @param   array $data       Gallery Config.
	 * @param   int   $gallery_id Gallery ID.
	 * @return  array               Gallery Config.
	 */
	public function maybe_sort_gallery( $data, $gallery_id ) {

		// Get sorting method.
		$sorting_method    = (string) $this->get_config( 'random', $data );
		$sorting_direction = $this->get_config( 'sorting_direction', $data );

		// Sort images based on method.
		switch ( $sorting_method ) {
			/**
			* Random.
			* - Again, by design, to ensure backward compat when upgrading from 1.3.7.x or older.
			* where we had a 'random' key = 0 or 1. Sorting was introduced in 1.3.8.
			*/
			case '1':
				// Shuffle keys.
				$keys = array_keys( $data['gallery'] );
				shuffle( $keys );

				// Rebuild array in new order.
				$new = [];
				foreach ( $keys as $key ) {
					$new[ $key ] = $data['gallery'][ $key ];
				}

				// Assign back to gallery.
				$data['gallery'] = $new;
				break;

			/**
			* Image Meta.
			*/
			case 'src':
			case 'title':
			case 'caption':
			case 'alt':
			case 'link':
				// Get metadata.
				$keys = [];
				foreach ( $data['gallery'] as $id => $item ) {
					$keys[ $id ] = wp_strip_all_tags( $item[ $sorting_method ] );
				}

				// Sort titles / captions.
				if ( 'ASC' === $sorting_direction ) {
					asort( $keys );
				} else {
					arsort( $keys );
				}

				// Iterate through sorted items, rebuilding gallery.
				$new = [];
				foreach ( $keys as $key => $title ) {
					$new[ $key ] = $data['gallery'][ $key ];
				}

				// Assign back to gallery.
				$data['gallery'] = $new;
				break;

			/**
			* Published Date.
			*/
			case 'date':
				// Get published date for each.
				$keys = [];
				foreach ( $data['gallery'] as $id => $item ) {
					// If the attachment isn't in the Media Library, we can't get a post date - assume now.
					$attachment = get_post( $id );
					if ( ! is_numeric( $id ) || ( false === $attachment ) ) {
						$keys[ $id ] = gmdate( 'Y-m-d H:i:s' );
					} else {
						$keys[ $id ] = $attachment->post_date;
					}
				}

				// Sort titles / captions.
				if ( 'ASC' === $sorting_direction ) {
					asort( $keys );
				} else {
					arsort( $keys );
				}

				// Iterate through sorted items, rebuilding gallery.
				$new = [];
				foreach ( $keys as $key => $title ) {
					$new[ $key ] = $data['gallery'][ $key ];
				}

				// Assign back to gallery.
				$data['gallery'] = $new;
				break;

			/**
			* None.
			* - Do nothing.
			*/
			case '0':
			case '':
				break;

			/**
			* If developers have added their own sort options, let them run them here
			*/
			default:
				$data = apply_filters( 'envira_gallery_sort_gallery', $data, $sorting_method, $gallery_id );
				break;

		}

		return $data;
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @since 1.0.0
	 *
	 * @return object The Envira_Gallery_Posttype object.
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Envira_Rest ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

$envira_rest = Envira_Rest::get_instance();
