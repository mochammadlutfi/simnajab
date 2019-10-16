<?php

namespace App\Helpers;

use Carbon\Carbon;
class GeneralHelp
{
	public static function tgl_indo($tgl)
	{
		$dt = new Carbon($tgl);
		setlocale(LC_TIME, 'IND');

		return $dt->formatLocalized('%d %B %Y');
	}
}
