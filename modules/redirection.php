<?php

/**
 * Copyright (C) 2008-2015, Rémi Jean (remi-jean@outlook.com)
 * <http://remijean.github.io/ZwiiCMS/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General License for more details.
 *
 * You should have received a copy of the GNU General License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class redirection extends core
{
	public static $name = 'URL de redirection';
	public static $inputs = [
		'redirection_url' => helpers::URL
	];

	public function config()
	{
		return
			template::openRow() .
			template::text('redirection_url', [
				'label' => 'URL de redirection',
				'value' => $this->getData('modules', $this->getUrl(1), 'redirection_url')
			]) .
			template::closeRow();
	}

	public function index()
	{
		$url = $this->getData('modules', $this->getUrl(0), 'redirection_url');
		if($url) {
			helpers::redirect($url, false);
		}
		else {
			self::$content = false;
		}
	}
}