<?php

// ---------------------------------------------------------

if (! function_exists('clog'))
{
	/**
	 * 
	 * Console log javascript
	 * 
	 */
		function clog($data, string $comment = null)
		{
			if(!empty($comment))
			{
				return '<script>console.log('. $comment .','. json_encode($data, JSON_NUMERIC_CHECK) .')</script>';
			}
			else
			{
				return '<script>console.log('. json_encode($data, JSON_NUMERIC_CHECK) .')</script>';
			}
		}
}

// ---------------------------------------------------------

if (! function_exists('transpose'))
{
	/**
	 * 
	 * Transpose Data
	 * 
	 */
		function transpose($data)
		{
			$retData = array();

			foreach ($data as $row => $columns) {
				foreach ($columns as $row2 => $column2) {
					$retData[$row2][$row] = $column2;
				}
			}
			return $retData;
		}
}