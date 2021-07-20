<?php
/**
  * This file is part of consoletvs/invoices.
  *
  * (c) Erik Campobadal <soc@erik.cat>
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace Oness\Sincontrol\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * This is the Setters trait.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
trait Setters
{
    /**
     * Set the invoice name.
     *
     * @method name
     *
     * @param string $name
     *
     * @return self
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the invoice number of authorizacion.
     *
     * @method auth
     *
     * @param int $num_auth
     *
     * @return self
     */
    public function auth($num_auth)
    {
        $this->auth = $num_auth;

        return $this;
    }

     /**
     * Set the invoice code.
     *
     * @method code
     *
     * @param string $code
     *
     * @return self
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set the invoice activity.
     *
     * @method activity
     *
     * @param string $activity
     *
     * @return self
     */
    public function activity($activity)
    {
        $this->activity = $activity;

        return $this;
    }
    /**
     * Set the invoice title.
     *
     * @method subtitle
     *
     * @param string $subtitle
     *
     * @return self
     */
    public function subtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }
    /**
     * Set the invoice legend.
     *
     * @method legend
     *
     * @param string $legend
     *
     * @return self
     */
    public function legend($legend)
    {
        $this->legend = $legend;

        return $this;
    }
    /**
     * Set the invoice title.
     *
     * @method title
     *
     * @param string $title
     *
     * @return self
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }
    /**
     * Set the invoice number.
     *
     * @method number
     *
     * @param int $number
     *
     * @return self
     */
    public function number($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Set the invoice decimal precision.
     *
     * @method decimals
     *
     * @param int $decimals
     *
     * @return self
     */
    public function decimals($decimals)
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Set the invoice logo URL.
     *
     * @method logo
     *
     * @param string $logo_url
     *
     * @return self
     */
    public function logo($logo_url)
    {
        $this->logo = $logo_url;

        return $this;
    }

    /**
     * Set the invoice date.
     *
     * @method date
     *
     * @param Carbon $date
     *
     * @return self
     */
    public function date(Carbon $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set the invoice notes.
     *
     * @method notes
     *
     * @param string $notes
     *
     * @return self
     */
    public function notes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Set the invoice business details.
     *
     * @method business
     *
     * @param array $details
     *
     * @return self
     */
    public function business($details)
    {
        $this->business_details = Collection::make($details);

        return $this;
    }

    /**
     * Set the invoice customer details.
     *
     * @method customer
     *
     * @param array $details
     *
     * @return self
     */
    public function customer($details)
    {
        $this->customer_details = Collection::make($details);

        return $this;
    }

     /**
     * Set the invoice qr details.
     *
     * @method qr
     *
     * @param array $details
     *
     * @return self
     */
    public function qr_details($details)
    {
        $this->qr_details = Collection::make($details);

        return $this;
    }

    /**
     * Set the invoice currency.
     *
     * @method currency
     *
     * @param string $currency
     *
     * @return self
     */
    public function currency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the invoice footnote.
     *
     * @method footnote
     *
     * @param string $footnote
     *
     * @return self
     */
    public function footnote($footnote)
    {
        $this->footnote = $footnote;

        return $this;
    }

    /**
     * Set the invoice due date.
     *
     * @method due_date
     *
     * @param Carbon $due_date
     *
     * @return self
     */
    public function due_date(Carbon $due_date = null)
    {
        $this->due_date = $due_date;
        return $this;
    }

    /**
     * Show/hide the invoice pagination.
     *
     * @method with_pagination
     *
     * @param boolean $with_pagination
     *
     * @return self
     */
    public function with_pagination($with_pagination)
    {
        $this->with_pagination = $with_pagination;
        return $this;
    }

    /**
     * Duplicate the header on each page.
     *
     * @method duplicate_header
     *
     * @param boolean $duplicate_header
     *
     * @return self
     */
    public function duplicate_header($duplicate_header)
    {
        $this->duplicate_header = $duplicate_header;
        return $this;
    }


    
}
