<style>
	.header{
		/*border:solid;*/
		text-align: center;
	}

	.content{
		width: 80%;
		margin-left: 10%;
		/*border:solid;*/
		height: 100px;
	}

	.footer{
		width: 80%;
		margin-left: 10%;
		/*border:solid;*/
		height: 100px;
		position: absolute;
		bottom: 0px;
	}

</style>
<body style="font-family: helvetica;">
	<div class="header">
		<img src="<?= base_url(); ?>/assets/images/bannerMail.png" alt="PTL" class="banner" style="width: 100%;">
	</div>
	<div class="content">
		<hr/>
		<div style="margin-top: 20px;">
			<?= view_cell('\App\Libraries\Email::content', ['content' => @$content]) ?>
		</div>

	</div>
	<div class="footer">
		<hr/>
		<div style="font-size:x-small;position:relative; width:100%; border:none 1px;background-color:rgba(0,0,0,0);" >
			<div style="position:relative;float:right;margin:-2px 0px 0px 0; border:none 1px;font-size:x-small">
				<table class="tablaSB" border="0" style ="margin:0px 0px 0px 0px;"cellspacing="0" cellpadding="0">
					<tr>
						<td style ="font-style:oblique; font-size:x-small;color:#333;text-align:right;">
							
						</td>
						<td style="opacity:1">
						</td>
					</tr>
				</table>
			</div>
			<div style ="none:none 1px;font-size:x-small;color:#333;" id="botonesAct">
				
			</div>
		</div>

	</div>
</body>