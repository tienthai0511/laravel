<?php
	########################################################
	# 各種INCLUDE処理
	########################################################

	// 基本読み込み
	include_once '_header_site.inc';

	include_once _CLS_DIR . 'ITCompanies.cls';
	include_once _CLS_DIR . 'ITProducttypeList.cls';
	include_once _CLS_DIR . 'ITEmployeesList.cls';
	include_once _CLS_DIR . 'ITProductsNew.cls';
	include_once _CLS_DIR . 'ITProducttypeProductsList.cls';
	include_once _CLS_DIR . 'ITEmployeesProductsList.cls';
	include_once _CLS_DIR . 'ITUrlInfo.cls';
	include_once _CLS_DIR . 'ITTags.cls';
	include_once _CLS_DIR . 'ITTagsList.cls';
	include_once _CLS_DIR . 'ITProductsNewFormList.cls';

	########################################################
	# パラメータ受け取り
	########################################################

	$editProductID = ASParameter::getNumericValue('editProductID');

	########################################################
	# パラメータチェック
	########################################################

	if ($editProductID == "" || $editProductID == NULL) {
		$ErrorMsg = "不正なアクセスです。正規の手順を踏んでください。";
		$myHtml = new ASHtml('_error.tpl', $MY_CARRIER, TRUE);
		unset($myHtml);
		exit;
	}

	$clsProductsNew = new ProductsNew($myDB);

	if (!$clsProductsNew->checkActive($editProductID)) {
		$ErrorMsg = "お探しの製品は公開期間が終了いたしました。";
		$myHtml = new ASHtml('_error.tpl', $MY_CARRIER, TRUE);
		unset($myHtml);
		exit;
	}

	unset($clsProductsNew);

	# ログイン状態でなければログインページへリダイレクトさせる
	if (!$IfUserLogin) {
		########################################################
		# ダウンロード押下→リダイレクト→ログインページが判別できるように
		# セッションに情報をセットしておく
		########################################################

		$SESSIONDATA['DownloadProductID'] = $editProductID;

		# セッション情報の更新
		$clsSessions = new Sessions($myDB);

		if (!$clsSessions->updateSessionsBySessionkey($COOKIEDATA->AccessSessionkey)){
			trigger_error("登録処理が完了出来ませんでした。データの更新ができませんでした。Updating Sessions Failed.", E_USER_ERROR);
			exit;
		}

		unset($clsSessions);

		# ログインページへリダイレクト
		header("location: " . _SSL_MAIN_URL . "users/login");
		exit;
	}

	########################################################
	# 製品情報取得
	########################################################

	$clsProductsNew = new ProductsNew($myDB);

	if (!$clsProductsNew->getProductsNewByID($editProductID) || $clsProductsNew->RecCnt != 1) {
		trigger_error("データを抽出出来ませんでした。 Searching ProductsNew Failed. editID:" . $editProductID, E_USER_ERROR);
		exit;
	}

	$wCatch = $clsProductsNew->Catch;
	$wName = $clsProductsNew->Name;
	$wKana = $clsProductsNew->Kana;
	$wCompany_id = $clsProductsNew->Company_id;
	$wAccount_id = $clsProductsNew->Account_id;
	$wCost = $clsProductsNew->Cost;
	$wTarget_user = $clsProductsNew->Target_user;
	$wProduct_info = $clsProductsNew->Product_info;
	$wDetail_title = $clsProductsNew->Detail_title;
	$wDetail_info = $clsProductsNew->Detail_info;
	$wMerit_title = $clsProductsNew->Merit_title;
	$wMerit_info = $clsProductsNew->Merit_info;
	$wSpec = $clsProductsNew->Spec;
	$wMeta_key = $clsProductsNew->Meta_key;
	$wMeta_desc = $clsProductsNew->Meta_desc;
	$wContact_company = $clsProductsNew->Contact_company;
	$wContact_dept = $clsProductsNew->Contact_dept;
	$wContact_address = $clsProductsNew->Contact_address;
	$wContact_other = $clsProductsNew->Contact_other;
	$wOverwrite_dept = $clsProductsNew->Overwrite_dept;
	$wLFStatus = $clsProductsNew->LF_Status;
	$wOption_button = $clsProductsNew->Option_button;
	$wOption_url = $clsProductsNew->Option_url;
	$wOption_url_url = $clsProductsNew->Option_url_url;
	$wOption_telimg = $clsProductsNew->Option_telimg;
	$CostNotes = $clsProductsNew->CostNotes;
	$EmployeeScaleLimit = $clsProductsNew->EmployeeScaleLimit;
	$MinEmployeeScale = $clsProductsNew->MinEmployeeScale;
	$MaxEmployeeScale = $clsProductsNew->MaxEmployeeScale;
	$wCost_Min = $clsProductsNew->Cost_Min;
	$wCost_Max = $clsProductsNew->Cost_Max;

	# 画像・ファイル関連
	$wProduct_img = $clsProductsNew->Product_img;
	$wDetail_img = $clsProductsNew->Detail_img;
	$wMerit_img = $clsProductsNew->Merit_img;
	$wDownload_file = $clsProductsNew->Download_file;
	$wOption_telimg_img = $clsProductsNew->Option_telimg_img;

	unset($clsProductsNew);

	# 提供形態を取得
	$clsProductsNewFormList = new ProductsNewFormList($myDB);

	$SearchObj = $Operator = array();
	$SearchObj['Product_id'] = $editProductID;
	$Operator['Product_id'] = '=';
	$SearchObj['Delete_flag'] = FALSE;
	$Operator['Delete_flag'] = '=';

	if (!$clsProductsNewFormList->getProductsNewFormList($SearchObj, 1, 1, 'allpage', $Operator)) {
		trigger_error("Searching ProductsNewForm Failed: ", E_USER_ERROR);
		exit;
	}

	for ($i = 0; $i < $clsProductsNewFormList->RecCnt; $i++) {
		$ProductFormID[] = $clsProductsNewFormList->Form_id[$i];
	}

	if (is_array($ProductFormID) && count($ProductFormID) > 0) {
		$pProductFormID = implode(',', $ProductFormID);
	}

	unset($clsProductsNewFormList);

	########################################################
	# 表示処理ほか
	########################################################

	$pCatch = $wCatch;
	$pName = $wName;
	$pKana = $wKana;
	$pCost = ($wCost) ? $wCost : "別途お問い合わせ";
	$pTarget_user = $wTarget_user;
	$pProduct_info = $wProduct_info;
	$pDetail_title = $wDetail_title;
	$pDetail_info = $wDetail_info;
	$pMerit_title = $wMerit_title;
	$pMerit_info = $wMerit_info;
	$pSpec = $wSpec;
	$pMeta_key = $wMeta_key;
	$pMeta_desc = $wMeta_desc;
	$pContact_company = $wContact_company;
	$pContact_dept = $wContact_dept;
	$pContact_address = $wContact_address;
	$pContact_other = $wContact_other;
	$pOverwrite_dept = $wOverwrite_dept;

	$pCost = (!is_null($Cost) && $Cost != '') ? number_format($Cost) . '円' : ' ';
	if ($EmployeeScaleLimit == 1) {
		$pEmployeeScale .= ($MinEmployeeScale) ? number_format($MinEmployeeScale) . '名以上' : '';
		$pEmployeeScale .= ($MaxEmployeeScale) ? number_format($MaxEmployeeScale) . '名未満' : '';
	} else {
		$pEmployeeScale = '全ての規模に対応';
	}
	if ($pProductFormID) {
		$pProductFormName = convertedToDisplayFormatNumericDataCommaDelimited($pProductFormID, $NEW_PRODUCT_FORM_VALUE, $NEW_PRODUCT_FORM_NAME, '[BR]');
	}
	$pProductCost = getProductCost($wCost_Min, $wCost_Max);// 価格表示を整形する関数

	########################################################
	# 企業名取得
	########################################################

	if ($wCompany_id) {
		$clsCompanies = new Companies($myDB);

		if (!$clsCompanies->getCompaniesByID($wCompany_id) || $clsCompanies->RecCnt != 1) {
			trigger_error("データを抽出出来ませんでした。 Searching ContentsMaster Failed. editID:" . $wCompany_id, E_USER_ERROR);
			exit;
		}

		$pCompanyName = $clsCompanies->Name;
		$pLFID = $clsCompanies->LFID;

		unset($clsCompanies);
	}

	########################################################
	# URLを検索
	########################################################

	if ($wCompany_id) {
		$clsUrlInfo = new UrlInfo($myDB);

		$SearchObj = $Operator = array();
		$SearchObj['Division_id'] = _URL_INFO_DIVISION_COMPANY;
		$Operator['Division_id'] = '=';
		$SearchObj['Primary_id'] = $wCompany_id;
		$Operator['Primary_id'] = '=';
		$SearchObj['Delete_flag'] = FALSE;
		$Operator['Delete_flag'] = '=';

		if (!$clsUrlInfo->getUrlInfoByCondition($SearchObj, $Operator)){
			$myDB->transactionRollback();
			trigger_error("データを抽出出来ませんでした。 Searching UrlInfo Failed. ", E_USER_ERROR);
			exit;
		}

		$pCompanyUrl = $clsUrlInfo->Url;

		unset($clsUrlInfo);
	}

	########################################################
	# 製品形態名取得
	########################################################

	if (is_array($wProducttypeProductID) && count($wProducttypeProductID) > 0) {
		$clsProducttypeList = new ProducttypeList($myDB);

		$SearchObj = $Operator = array();
		$SearchObj['ID'] = '(' . implode(',', array_unique($wProducttypeProductID)) . ')';
		$Operator['ID'] = 'IN';
		$SearchObj['Delete_flag'] = FALSE;
		$Operator['Delete_flag'] = '=';

		if (!$clsProducttypeList->getProducttypeList($SearchObj, 1, 1, 'allpage', $Operator)) {
			trigger_error("Searching Producttype Failed: ", E_USER_ERROR);
			exit;
		}

		if ($clsProducttypeList->RecCnt > 0) {
			$pProducttypeName = implode(', ', $clsProducttypeList->Name);
		}

		unset($clsProducttypeList);
	}

	########################################################
	# 企業利用規模名取得
	########################################################

	if (is_array($wEmployeesProductID) && count($wEmployeesProductID) > 0) {
		$pEmployeesName = _get_scale_width(implode(',', $wEmployeesProductID));
	}

	########################################################
	# パンくず用に製品の第1カテゴリー(タグ)とカテゴリーを取得する
	########################################################

	$clsTags = new Tags($myDB);

	$Condition = "t1.ID = (SELECT product_tags.Tag_id FROM product_tags, tags WHERE tags.ID = product_tags.Tag_id AND tags.Tag_kind_id = 1 AND tags.Active = 1 AND product_tags.Product_id = " . intval($editProductID) . " ORDER BY Sort LIMIT 1)";
	$Condition .= " AND t3.ID > 0";// 必ずカテゴリー情報を取得するため

	if (!$clsTags->getTagDataByCondition($Condition, "t3.Sort")) {
		trigger_error("データを抽出出来ませんでした。 Searching ContentsMaster Failed. editID:" . $editID, E_USER_ERROR);
		exit;
	}

	$ProductTagID = $clsTags->TagID;
	$ProductTagName = $clsTags->TagName;
	$ProductTagUrl = $clsTags->TagUrl;
	$ProductCategoryName = $clsTags->CategoryName;
	$ProductCategoryUrl = $clsTags->CategoryUrl;
	$IfNormalTagSetting = ($ProductTagName) ? TRUE : FALSE;

	unset($clsTags);

	########################################################
	# 画像表示系
	########################################################

	$wProduct_img_path = _getUploadImgPath(_UPLOAD_NEW_PRODUCTS_LOGO_DIR, _UPLOAD_NEW_PRODUCTS_LOGO_URL, $wProduct_img);
	$wDetail_img_path = _getUploadImgPath(_UPLOAD_PRODUCTS_DETAIL_DIR, _UPLOAD_PRODUCTS_DETAIL_URL, $wDetail_img);
	$wMerit_img_path = _getUploadImgPath(_UPLOAD_PRODUCTS_MERIT_DIR, _UPLOAD_PRODUCTS_MERIT_URL, $wMerit_img);
	$wDownload_file_path = _getUploadImgPath(_UPLOAD_PRODUCTS_DL_DIR, _UPLOAD_PRODUCTS_DL_URL, $wDownload_file);
	$wOption_telimg_img_path = _getUploadImgPath(_UPLOAD_PRODUCTS_TELIMG_DIR, _UPLOAD_PRODUCTS_TELIMG_URL, $wOption_telimg_img);

	$IfProductImg = ($wProduct_img_path) ? TRUE : FALSE;
	$IfDetailImg = ($wDetail_img_path) ? TRUE : FALSE;
	$IfMeritImg = ($wMerit_img_path) ? TRUE : FALSE;
	$IfDownloadFile = ($wDownload_file_path) ? TRUE : FALSE;
	$IfOptionTelImg = ($wOption_telimg_img_path) ? TRUE : FALSE;

	# ダウンロードファイルサイズの取得
	if ($IfDownloadFile) {
		$wDownload_file_dir = _getUploadImgPath(_UPLOAD_PRODUCTS_DL_DIR, _UPLOAD_PRODUCTS_DL_DIR, $wDownload_file);
		$Download_file_sze = ceil(filesize($wDownload_file_dir) / 1024);//KBへ変換(切り上げ)
	}

	########################################################
	# title, meta情報を生成
	########################################################

	$pTitle = ($ProductTagName) ? $pName . "／" . $ProductTagName . "｜製品資料ダウンロード" : $pName . "｜製品資料ダウンロード";
	//$pMetaKeywords = ($pMeta_key) ? $pMeta_key : $pName . "," . $pCompanyName;
	$pMetaKeywords = "ダウンロード,";
	if ($pCatch) $pMetaKeywords .= $pCatch . "　";
	$pMetaKeywords .= $pName;
	if ($pCompanyName) $pMetaKeywords .= "," . $pCompanyName;
	if ($ProductTagName) $pMetaKeywords .= "," . $ProductTagName;
	if ($pMeta_key) $pMetaKeywords .= "," . $pMeta_key;
	$pMetaDescription = ($pMeta_desc) ? $pName . "の製品資料ダウンロードページ。" . $pMeta_desc : $pName . "の製品資料ダウンロードページ。";
	$pMetaPropertyUrl = _MAIN_URL . "products/" . $editProductID;
	$pMetaPropertyImage = substr(_MAIN_URL, 0, -1) . $wProduct_img_path;
	$pMetaPropertyDescription = str_replace(array("\r\n","\n","\r"), '', $pProduct_info);

	########################################################
	# リファラーから前ページがカテゴリー一覧だったか調べる
	########################################################

	$BeforePageCategoryURL = preg_replace('/' . _SITE_DOMAIN_HANBETU . '([0-9a-z\_\-]+).*/', '${1}', $_SERVER['HTTP_REFERER']);

	if ($BeforePageCategoryURL) {
		$clsUrlInfo = new UrlInfo($myDB);

		$SearchObj = $Operator = array();
		$SearchObj['Division_id'] = _URL_INFO_DIVISION_TAG;
		$Operator['Division_id'] = '=';
		$SearchObj['Url'] = $BeforePageCategoryURL;
		$Operator['Url'] = '=';
		$SearchObj['Delete_flag'] = FALSE;
		$Operator['Delete_flag'] = '=';

		if (!$clsUrlInfo->getUrlInfoByCondition($SearchObj, $Operator)){
			$myDB->transactionRollback();
			trigger_error("データを抽出出来ませんでした。 Searching UrlInfo Failed. ", E_USER_ERROR);
			exit;
		}

		if ($clsUrlInfo->RecCnt == 1) {
			$BeforePageCategory = '_tag_' . $clsUrlInfo->Primary_id;
		}

		unset($clsUrlInfo);
	}

	########################################################
	# Ifタグ作成
	########################################################

	$IfOptionButton = ($wOption_button) ? TRUE : FALSE;
	$IfMerit = ($pMerit_title || $pMerit_info || $IfMeritImg) ? TRUE : FALSE;
	$IfSpec = ($pSpec) ? TRUE : FALSE;
	//$IfOverwriteDept = ($pOverwrite_dept) ? TRUE : FALSE;
	$IfOverwriteDept = FALSE;
	$IfContactCompany = ($pContact_company) ? TRUE : FALSE;
	$IfContactDept = ($pContact_dept) ? TRUE : FALSE;
	$IfContactAddress = ($pContact_address) ? TRUE : FALSE;
	$IfAlreadyCart = (is_array($CARTDATA->CartProductID) && in_array($editProductID, $CARTDATA->CartProductID)) ? TRUE : FALSE;
	$IfLFTag = ($pLFID && $wLFStatus == 1) ? TRUE : FALSE;
	$IfBeforePageCategory = ($BeforePageCategory) ? TRUE : FALSE;
	$IfOptionURL = ($wOption_url && $wOption_url_url) ? TRUE : FALSE;
	$IfOptionTelImg = ($wOption_telimg && $wOption_telimg_img_path) ? TRUE : FALSE;
	$IfCostNotes = ($CostNotes) ? TRUE : FALSE;

	########################################################
	# レコメンド情報取得
	########################################################

	$clsProductsNewList = new ProductsNewList($myDB);

	$MainProductIDArr[] = $editProductID;// メイン用の製品が表示されないように指定

	if (!$clsProductsNewList->getRecommendList($MainProductIDArr, $MainProductIDArr, 3, TRUE)) {
		trigger_error("Searching Products Failed: ", E_USER_ERROR);
		exit;
	}

	$RecommendProductsListLoop = $clsProductsNewList->RecCnt;
	for ($i = 0; $i < $RecommendProductsListLoop; $i++) {
		$RecommendProductID[$i] = $clsProductsNewList->ProductID[$i];
		$RecommendProductName[$i] = $clsProductsNewList->ProductName[$i];
		$RecommendProductCompanyName[$i] = $clsProductsNewList->CompanyName[$i];
		$RecommendProductInfo[$i] = str_replace(array("\r\n","\n","\r"), '', $clsProductsNewList->ProductInfo[$i]);
		$RecommendProductTagName[$i] = $clsProductsNewList->TagName[$i];

		$RecommendProductImgPath[$i] = _getUploadImgPath(_UPLOAD_NEW_PRODUCTS_LOGO_DIR, _UPLOAD_NEW_PRODUCTS_LOGO_URL, $clsProductsNewList->ProductImg[$i]);
	}

	$IfRecommend = ($RecommendProductsListLoop > 0) ? TRUE : FALSE;

	unset($clsProductsNewList);

	########################################################
	# フッター生成
	########################################################

	include_once _DOCUMENT_ROOT . '_footer.php';

	########################################################
	# 表示プロセス
	########################################################

	ASHtml::setValue('work', NULL);

	$myHtml = new ASHtml('default', $MY_CARRIER, TRUE);
	unset($myHtml);

