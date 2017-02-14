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
													<p><b>Hi there</b></p>
													<p>Thank you for you for choosing <font style="color:#0077cc;font-weight:bold">premiumLinkGenerator</font> product !</p>

													<p>Your <b><font color="#0077cc">Order # <?= $content['order_key'] ?></font></b> is
													now being in processing state and you will be updated with another email shortly
													when the campaign has been set.</p>

													<p>For your reference, your order details are shown below.<br></p>
													<hr><h3 style="color:#0077cc;display:block;font-family:Arial;font-size:26px;font-weight:bold;margin-top:10px;margin-right:0;margin-bottom:10px;margin-left:0;text-align:left;line-height:150%">Order details:</h3>
													<table style="width:100%;border:1px solid #eee" border="1" cellpadding="6" cellspacing="0">
														<thead>
															<tr>
																<th scope="col" style="text-align:left;border:1px solid #eee">Product</th>
																<th scope="col" style="text-align:left;border:1px solid #eee">Quantity</th>
																<th scope="col" style="text-align:left;border:1px solid #eee">Price</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word"><?=$content['product'] ?>				
																</td>
																<td style="text-align:left;vertical-align:middle;border:1px solid #eee">1</td>
																<td style="text-align:left;vertical-align:middle;border:1px solid #eee">
																	<span >$ <?=$content['amount'] ?></span>
																</td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th scope="row" colspan="2" style="text-align:left;border:1px solid #eee;border-top-width:4px">Cart Subtotal:
																</th>
																<td style="text-align:left;border:1px solid #eee;border-top-width:4px">
																	<span>$ <?=$content['amount'] ?></span>
																</td>
															</tr>
																<tr>
																	<th scope="row" colspan="2" style="text-align:left;border:1px solid #eee">Order Total:
																	</th>
																	<td style="text-align:left;border:1px solid #eee">
																		<span>$ 0</span>
																	</td>
																</tr>
														</tfoot>
													</table>
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