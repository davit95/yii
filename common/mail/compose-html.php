<?php
	use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<!--IN PROGRESS-->
<?php $this->beginBody() ?>
<table>
	<td align="center" valign="top">
	<table style="border-radius:6px!important;background-color:#0077cc;border:1px solid #dcdcdc;border-radius:6px!important" border="0" cellpadding="0" cellspacing="0" width="600">
		<tbody>
			<tr>
				<td align="center" valign="top">
				<table style="background-color:#0077cc;color:#ffffff;border-top-left-radius:6px!important;border-top-right-radius:6px!important;border-bottom:0;font-family:Arial;font-weight:bold;line-height:100%;vertical-align:middle" bgcolor="#fe5e2d" border="0" cellpadding="0" cellspacing="0" width="600">
					<tbody>
						<tr>
							<td>
								<p style="text-align:center">
									<img style="text-align:center;display:inline;border:none;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize"  class="CToWUd" alt = "logo" class="logo" src="http://dev.premiumlinkgenerator.com/images/logo.png" width="80" height="80"/>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
			<tr>
			<td align="center" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="600">
					<tbody>
						<tr>
							<td style="background-color:#fdfdfd;border-radius:6px!important" valign="top">
								<table border="0" cellpadding="20" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td valign="top">
												<div style="color:#737373;font-family:Arial;font-size:14px;line-height:150%;text-align:left">
													<p>
														<b>Hi there</b>
													</p>
													<p>
														<?= $content['message'] ?>
													</p>
													<hr>
													<p>
													<b>Support Email:</b>
													<a href="mailto:support@premiumlinkgenerator.com" target="_blank">support@premiumlinkgenerator.com</a>
													</p>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
		</tbody>
	</table>	
	</td>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>