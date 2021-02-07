<?php


namespace AmpedWeb\GlideInABox\Traits;

use AmpedWeb\GlideInABox\Exceptions\InvalidDimensionException;
use AmpedWeb\GlideInABox\Exceptions\InvalidMarkFitException;
use AmpedWeb\GlideInABox\Exceptions\InvalidMarkPositionException;

/**
 * This trait provides watermarks functionality
 *
 * @package AmpedWeb\GlideInABox\Traits
 * @link    https://glide.thephpleague.com/1.0/api/watermarks/
 */
trait Watermarks
{
    use DimensionParser;

    /**
     * @property array $buildParams
     */

    /** @var string  */
    public static $MARKPOS_TOP_LEFT = 'top-left';

    /** @var string  */
    public static $MARKPOS_TOP = 'top';

    /** @var string  */
    public static $MARKPOS_TOP_RIGHT = 'top-right';

    /** @var string  */
    public static $MARKPOS_LEFT = 'left';

    /** @var string  */
    public static $MARKPOS_CENTER = 'center';

    /** @var string  */
    public static $MARKPOS_RIGHT = 'right';

    /** @var string  */
    public static $MARKPOS_BOTTOM_LEFT = 'bottom-left';

    /** @var string  */
    public static $MARKPOS_BOTTOM = 'bottom';

    /** @var string  */
    public static $MARKPOS_BOTTOM_RIGHT = 'bottom-right';

    /**
     * Adds a watermark to the image.
     *
     * Must be a path to an image in the watermarks file system, as configured in your server.
     *
     * @param string $filename
     *
     * @return Watermarks
     */
    public function mark(string $filename)
    {
        $this->buildParams['mark'] = $filename;

        return $this;
    }

    /**
     * Sets the width of the watermark in pixels, or using relative dimensions.
     *
     * @param string $dimension
     *
     * @return Watermarks
     * @throws InvalidDimensionException
     */
    public function markWidth(string $dimension)
    {
        $this->buildParams['markw'] = $this->parseDimension($dimension);

        return $this;
    }

    /**
     * Sets the height of the watermark in pixels, or using relative dimensions.
     *
     * @param string $dimension
     *
     * @return Watermarks
     * @throws InvalidDimensionException
     */
    public function markHeight(string $dimension)
    {
        $this->buildParams['markh'] = $this->parseDimension($dimension);

        return $this;
    }

    /**
     * Sets how the watermark is fitted to its target dimensions.
     *
     * Accepts:
     *
     * - `contain`: Default. Resizes the image to fit within the width and height boundaries without cropping,
     * distorting or altering the aspect ratio.
     * - `max`: Resizes the image to fit within the width and height boundaries without cropping, distorting or
     * altering the aspect ratio, and will also not increase the size of the image if it is smaller than the output
     * size.
     * - `fill`: Resizes the image to fit within the width and height boundaries without cropping or distorting the
     * image, and the remaining space is filled with the background color. The resulting image will match the
     * constraining dimensions.
     * - `stretch`: Stretches the image to fit the constraining dimensions exactly. The resulting image will fill the
     * dimensions, and will not maintain the aspect ratio of the input image.
     * - `crop`: Resizes the image to fill the width and height boundaries and crops any excess image data. The
     * resulting image will match the width and height constraints without distorting the image. See the crop page for
     * more information.
     *
     * @param string $fit Accepts the following values:
     *                    - `contain`: Default. Resizes the image to fit within the width and height boundaries without
     *                    cropping, distorting or altering the aspect ratio.
     *                    - `max`: Resizes the image to fit within the width and height boundaries without cropping,
     *                    distorting or altering the aspect ratio, and will also not increase the size of the image if
     *                    it is smaller than the output size.
     *                    - `fill`: Resizes the image to fit within the width and height boundaries without cropping or
     *                    distorting the image, and the remaining space is filled with the background color. The
     *                    resulting image will match the constraining dimensions.
     *                    - `stretch`: Stretches the image to fit the constraining dimensions exactly. The resulting
     *                    image will fill the dimensions, and will not maintain the aspect ratio of the input image.
     *                    - `crop`: Resizes the image to fill the width and height boundaries and crops any excess
     *                    image data. The resulting image will match the width and height constraints without
     *                    distorting the image. See the crop page for more information.
     *
     * @return Watermarks
     * @throws InvalidMarkFitException
     */
    public function markFit(string $fit = 'contain')
    {
        if ($fit !== Size::$FIT_CONTAIN &&
            $fit !== Size::$FIT_CROP &&
            $fit !== Size::$FIT_FILL &&
            $fit !== Size::$FIT_MAX &&
            $fit !== Size::$FIT_STRETCH
        ) {
            throw new InvalidMarkFitException();
        }

        $this->buildParams['markfit'] = $fit;

        return $this;
    }

    /**
     * Sets how far the watermark is away from the left and right edges of the image.
     *
     * Set in pixels, or using relative dimensions. Ignored if `markpos` is set to center.
     *
     * @param string $dimension
     *
     * @return Watermarks
     * @throws InvalidDimensionException
     */
    public function markX(string $dimension)
    {
        $this->buildParams['markx'] = $this->parseDimension($dimension);

        return $this;
    }

    /**
     * Sets how far the watermark is away from the top and bottom edges of the image.
     *
     * Set in pixels, or using relative dimensions. Ignored if `markpos` is set to center.
     *
     * @param string $dimension
     *
     * @return Watermarks
     * @throws InvalidDimensionException
     */
    public function markY(string $dimension)
    {
        $this->buildParams['marky'] = $this->parseDimension($dimension);

        return $this;
    }

    /**
     * Sets how far the watermark is away from edges of the image.
     *
     * Basically a shortcut for using both `markx` and `marky`. Set in pixels, or using relative dimensions. Ignored if
     * `markpos` is set to center.
     *
     * @param string $dimension
     *
     * @return Watermarks
     */
    public function markPad(string $dimension)
    {
        $this->buildParams['markpad'] = $this->parseDimension($dimension);

        return $this;
    }

    /**
     * Sets where the watermark is positioned.
     *
     * Accepts `top-left`, `top`, `top-right`, `left`, `center`, `right`, `bottom-left`, `bottom`, `bottom-right`.
     * Default is `center`.
     *
     * @param string $position Accepts :
     *                         - `top-left`
     *                         - `top`,
     *                         - `top-right`,
     *                         - `left`,
     *                         - `center`,
     *                         - `right`,
     *                         - `bottom-left`,
     *                         - `bottom`,
     *                         - `bottom-right`.
     *
     * @return Watermarks
     */
    public function markPos(string $position = 'center')
    {
        if ($position !== static::$MARKPOS_TOP_LEFT &&
            $position !== static::$MARKPOS_TOP &&
            $position !== static::$MARKPOS_TOP_RIGHT &&
            $position !== static::$MARKPOS_LEFT &&
            $position !== static::$MARKPOS_CENTER &&
            $position !== static::$MARKPOS_RIGHT &&
            $position !== static::$MARKPOS_BOTTOM_LEFT &&
            $position !== static::$MARKPOS_BOTTOM &&
            $position !== static::$MARKPOS_BOTTOM_RIGHT
        ) {
            throw new InvalidMarkPositionException();
        }

        $this->buildParams['markpos'] = $position;

        return $this;
    }

    /**
     * Sets the opacity of the watermark.
     *
     * Use values between `0` and `100`, where `100` is fully opaque, and `0` is fully transparent. The default value
     * is `100`.
     *
     * @param int $alpha
     */
    public function markAlpha(int $alpha = 100)
    {
        $alpha = max(0, $alpha);
        $alpha = min($alpha, 100);

        $this->buildParams['markalpha'] = $alpha;

        return $this;
    }
}