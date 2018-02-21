/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Droits des groupes
 */
$("#userEditGroup").on("change", function() {
	$(".userEditGroupDescription").hide();
	$("#userEditGroupDescription" + $(this).val()).show();
}).trigger("change");