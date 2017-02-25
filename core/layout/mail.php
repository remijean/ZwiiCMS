<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="x-apple-disable-message-reformatting">
	<title><?php echo $subject; ?></title>
	<!--[if mso]>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>
	<![endif]-->
	<!--[if !mso]>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<![endif]-->
	<style>
		html,
		body {
			margin: 0 auto !important;
			padding: 0 !important;
			height: 100% !important;
			width: 100% !important;
		}
		* {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}
		div[style*="margin: 16px 0"] {
			margin:0 !important;
		}
		table,
		td {
			mso-table-lspace: 0pt !important;
			mso-table-rspace: 0pt !important;
		}
		table {
			border-spacing: 0 !important;
			border-collapse: collapse !important;
			table-layout: fixed !important;
			margin: 0 auto !important;
		}
		table table table {
			table-layout: auto;
		}
		*[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
		}
		.x-gmail-data-detectors,
		.x-gmail-data-detectors *,
		.aBn {
			border-bottom: 0 !important;
			cursor: default !important;
		}
		.a6S {
			display: none !important;
			opacity: 0.01 !important;
		}
		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
			.email-container {
				min-width: 375px !important;
			}
		}
	</style>
</head>
<body width="100%" bgcolor="#EBEEF2" style="margin: 0; padding: 10px; mso-line-height-rule: exactly;">
<center style="width: 100%; background: #EBEEF2; text-align: left;">
	<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
		<?php echo $subject; ?>
	</div>
	<div style="max-width: 500px; margin: auto;" class="email-container">
		<!--[if mso]>
			<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="500" align="center">
				<tr>
					<td>
		<![endif]-->
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 500px;">
			<tr>
				<td bgcolor="#ffffff">
					<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td style="border-bottom: 1px solid #EBEEF2; padding: 20px; font-family: 'Open Sans', sans-serif; font-size: 19px; line-height: 24px; text-align: center; color: #212223;">
								<?php echo $this->getData(['config', 'title']); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 500px;">
			<tr>
				<td bgcolor="#ffffff">
					<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td style="padding: 30px; font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 19px; color: #212223;">
								<?php echo nl2br($content); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 500px;">
			<tr>
				<td bgcolor="#ffffff">
					<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td style="border-top: 1px solid #EBEEF2; padding: 20px; text-align: center; font-family: 'Open Sans', sans-serif; font-size: 12px; line-height: 17px; color: #212223;">
								<a href="<?php echo helper::baseUrl(false); ?>" target="_blank"><?php echo $this->getData(['config', 'title']); ?></a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!--[if mso]>
					</td>
				</tr>
			</table>
		<![endif]-->
	</div>
</center>
</body>
</html>