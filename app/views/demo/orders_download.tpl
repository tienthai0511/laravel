<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="-1">
<title>__s::r::pTitle__</title>
<meta name="Description" content="__s::pMetaDescription__" />
<meta name="Keywords" content="__s::pMetaKeywords__" />
<meta name="Author" content="IT Trend" />
<meta name="Copyright" content="&amp;IT Trend" />
__i::_head.tpl__
<link href="/css/common/style.css" rel="stylesheet" type="text/css" />
<link href="/css/cat_detail.css" rel="stylesheet" type="text/css" />	
<link href="/css/products_l.css" rel="stylesheet" type="text/css" />
<link href="/css/y_download.css" rel="stylesheet" type="text/css" />
<script>
function DownloadMain(ProductID) {
	$('#dl_btn').html('<img class="mb5" src="/img/download/btn_download_02.png" alt="ダウンロード済み">');
	setTimeout(goDownloadPage, 300, ProductID);
}
function DownloadReccomend(ProductID) {
	$('#recommend'+ProductID).html('<img class="mb5" src="/img/download/btn_download_04.png" alt="ダウンロード済み">');
	setTimeout(goDownloadPageRecommend, 300, ProductID);
}
function goDownloadPage(ProductID) {
	if (ProductID > 0) {
		window.location = '__s::r::_MAIN_URL__orders_download.php?editProductID=' + ProductID + '&p=download';
	} else {
		alert('製品情報が正常に送信されませんでした。<br>お手数ですが画面を更新していただくようお願いいたします。');
	}
}
function goDownloadPageRecommend(ProductID) {
	if (ProductID > 0) {
		window.location = '__s::r::_MAIN_URL__orders_download.php?editProductID=' + ProductID + '&p=recommend_download';
	} else {
		alert('製品情報が正常に送信されませんでした。<br>お手数ですが画面を更新していただくようお願いいたします。');
	}
}
</script>

<script src="/js/DLPO.js" type="text/javascript"></script>
<script type="text/javascript">DLPODisableTpc();</script>
</head>

<body class="index">

<!-- 価格とポイントのABCテスト用 -->
<div class="DLPODefault"></div>
<script type='text/javascript'>DLPOCreate('pdf_p','charset=UTF-8','keyword='+escape(document.referrer));</script>
<!-- 価格とポイントのABCテスト用 -->

<form name="fList" action="" method="post" onSubmit="return false;">

<div id="container_download">
	<div id="header">
		<div class="logo">
			<a href="___MAIN_URL__"><img src="/img/common/template/logo.png" width="251" height="61" alt="ITトレンド" /></a>
		</div><!-- / .logo -->
	</div><!-- / #header -->


	<div id="main">
		<div id="conts">
			<!--コンテンツが入ります。-->
			<div id="main_contents" class="static">

				<div class="space_01 mt20"></div>
				<div id="dlpoSetImage">
					<p><img src="/img/download/lownload_bar.png" alt="下記の製品をダウンロードします" width="730" height="44" /></p>
				</div>

				<div class="resultBox">
					<div class="title clearfix">
						<h2>__s::r::pCatch____s::r::pName__</h2>
					</div>
					<div class="inner clearfix">
						<div class="download_recomend_logo_108"><img src="__s::r::wProduct_img_path__" alt="" class="company_image" width="108" height="108" ></div>
						<div class="detail height02 clearfix">
							<div class="text">
								<p>__pProduct_info__</p>
								<p class="article">掲載会社：__s::r::pCompanyName__</p>
							</div>
							<div class="data">
								<table>
									<tr>
										<th>提供形態</th>
										<td>__s::r::pProductFormName__</td>
									</tr>
									<tr>
										<th>対象従業員規模</th>
										<td>__s::r::pEmployeeScale__</td>
									</tr>

									<!-- DLPOでABCテスト 
									<tr class="dlpo_cost">
										<th>参考価格</th>
										<td class="l_height13">__s::r::pProductCost____IfCostNotes__<br><a class="tipsy fs11" title="__s::r::CostNotes__">※参考価格補足</a>__IfCostNotes__</td>
									</tr>
									<!-- DLPOでABCテスト -->

								</table>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="all_request">
				<div class="inner">
					<div id="dl_btn" class="bg">
						<a href="/orders_download.php?editProductID=__s::r::editProductID__&p=download" target="_blank" onclick="javascript:_gaq.push(['_trackEvent','Orders-upper','Download','[Download]',1,true]);"><img src="/img/download/btn_download_01.png" width="210" height="33" alt="資料ダウンロード" /></a>
						<p>ボタン押下後、ダウンロードが開始されます。</p>
					</div>
					<!--div id="dl_btn" class="bg">
						<img src="/img/download/btn_download_02.png" alt="ダウンロード済み" />
					</div-->
				</div>
			</div>

			__IfRecommend__
			<div id="dlpoSetImage">
				<p><img src="/img/download/recommend_dl_bar.png" alt="おすすめダウンロード製品" width="730" height="44" /></p>
				<div class="download_title_001">同カテゴリーで以下の製品資料もダウンロードできます。</div>

				__RecommendProductsListLoop__
				<div class="download_recomend_box">
					<div class="download_recomend_logo"><img src="__s::r::RecommendProductImgPath__" class="mh50" /></div>
					<div class="download_recomend_box2">
						<div class="download_recomend_text"><span>__s::r::RecommendProductName__</span></div>
						<div class="download_recomend_text2"><p>__s::r::RecommendProductCompanyName__</p></div>
					</div><!--ownload_recomend_box2 -->
					<div id="recommend__s::r::RecommendProductID__" class="download_recomend_btn">
						<!--a href="javascript:void(0);" onclick="javascript:DownloadReccomend(__s::r::RecommendProductID__); return false;"><img src="/img/download/btn_download_03.png" width="109" height="20" alt="資料請求リストに追加" id="add_btn_"/></a-->
						<a href="/orders_download.php?editProductID=__s::r::RecommendProductID__&p=recommend_download" target="_blank" onclick="javascript:_gaq.push(['_trackEvent','Orders-below','Download','[Recommend_download]',1,true]);"><img src="/img/download/btn_download_03.png" width="109" height="20" alt="資料請求リストに追加" /></a>
					</div>
				</div><!--download_recomend_box -->
				__RecommendProductsListLoop__
			</div><!--main_contents -->
			__IfRecommend__

		</div><!-- / #conts -->

	</div><!--main -->

	__i::_orders_footer.tpl__
</div><!--container -->
__HiddenValues__

</form>

__i::_analytics.tpl__

</body>
</html>
