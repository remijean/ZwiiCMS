/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2017, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

core.confirm(
	"Souhaitez-vous accéder à l'interface de modification de la page ? En cas de refus, vous serez redirigé vers l'URL saisie dans le module de redirection.",
	function() {
		$(location).attr("href", "<?php echo helper::baseUrl(); ?>page/edit/<?php echo $this->getUrl(0); ?>");
	},
	function() {
		$(location).attr("href", "<?php echo helper::baseUrl() . $this->getUrl(); ?>/force");
	}
);