<?php
/**
 * Class d'internationnalisation
 */
class RaptorI18N {
	
	const SYSTEM_LANG = 'fr';
	const SYSTEM_COUNTRY = 'FR';
	const MAX_RECURCIVITY = 10;
	
	/**
	 * Code de la langue courante
	 *
	 * @var string
	 */
	private static $_lang = NULL;
	
	/**
	 * Code du pays courant
	 *
	 * @var string
	 */
	private static $_country = NULL;
	
	/**
	 * Traduction des noms de constantes
	 *
	 * @see Zend_Locale_Data_Translation
	 *
	 * @var array
	 */
	private static $_localeTranslation = array(
		'Australia' => 'AU',
		'Austria' => 'AT',
		'Belgium' => 'BE',
		'Brazil' => 'BR',
		'Canada' => 'CA',
		'China' => 'CN',
		'Czech Republic' => 'CZ',
		'Denmark' => 'DK',
		'Finland' => 'FI',
		'France' => 'FR',
		'Germany' => 'DE',
		'Greece' => 'GR',
		'Hong Kong SAR' => 'HK',
		'Hungary' => 'HU',
		'Iceland' => 'IS',
		'Ireland' => 'IE',
		'Italy' => 'IT',
		'Japan' => 'JP',
		'Korea' => 'KP',
		'Mexiko' => 'MX',
		'The Netherlands' => 'NL',
		'New Zealand' => 'NZ',
		'Norway' => 'NO',
		'Poland' => 'PL',
		'Portugal' => 'PT',
		'Russia' => 'RU',
		'Singapore' => 'SG',
		'Slovakia' => 'SK',
		'Spain' => 'ES',
		'Sweden' => 'SE',
		'Switzerland' => 'CH',
		'Taiwan' => 'TW',
		'Turkey' => 'TR',
		'United Kingdom' => 'GB',
		'United States' => 'US',

		'Chinese' => 'zh',
		'Czech' => 'cs',
		'Danish' => 'da',
		'Dutch' => 'nl',
		'English' => 'en',
		'Finnish' => 'fi',
		'French' => 'fr',
		'German' => 'de',
		'Greek' => 'el',
		'Hungarian' => 'hu',
		'Icelandic' => 'is',
		'Italian' => 'it',
		'Japanese' => 'ja',
		'Korean' => 'ko',
		'Norwegian' => 'no',
		'Polish' => 'pl',
		'Portuguese' => 'pt',
		'Russian' => 'ru',
		'Slovak' => 'sk',
		'Spanish' => 'es',
		'Swedish' => 'sv',
		'Turkish' => 'tr'
	);
	
	/**
	 * Les locales acceptées
	 *
	 * @see Zend_Locale
	 *
	 * @var array
	 */
	private static $_localeData = array(
		'default' => true, 'aa_DJ' => true, 'aa_ER' => true, 'aa_ET' => true, 'aa' => true,
		'af_NA' => true, 'af_ZA' => true, 'af' => true, 'ak_GH' => true, 'ak' => true,
		'am_ET' => true, 'am' => true, 'ar_AE' => true, 'ar_BH' => true, 'ar_DZ' => true,
		'ar_EG' => true, 'ar_IQ' => true, 'ar_JO' => true, 'ar_KW' => true, 'ar_LB' => true,
		'ar_LY' => true, 'ar_MA' => true, 'ar_OM' => true, 'ar_QA' => true, 'ar_SA' => true,
		'ar_SD' => true, 'ar_SY' => true, 'ar_TN' => true, 'ar_YE' => true, 'ar' => true,
		'as_IN' => true, 'as' => true, 'az_AZ' => true, 'az' => true, 'be_BY' => true,
		'be' => true, 'bg_BG' => true, 'bg' => true, 'bn_BD' => true, 'bn_IN' => true,
		'bn' => true, 'bo_CN' => true, 'bo_IN' => true, 'bo' => true, 'bs_BA' => true,
		'bs' => true, 'byn_ER'=> true, 'byn' => true, 'ca_ES' => true, 'ca' => true,
		'cch_NG'=> true, 'cch' => true, 'cop_EG'=> true, 'cop_US'=> true, 'cop' => true,
		'cs_CZ' => true, 'cs' => true, 'cy_GB' => true, 'cy' => true, 'da_DK' => true,
		'da' => true, 'de_AT' => true, 'de_BE' => true, 'de_CH' => true, 'de_DE' => true,
		'de_LI' => true, 'de_LU' => true, 'de' => true, 'dv_MV' => true, 'dv' => true,
		'dz_BT' => true, 'dz' => true, 'ee_GH' => true, 'ee_TG' => true, 'ee' => true,
		'el_CY' => true, 'el_GR' => true, 'el' => true, 'en_AS' => true, 'en_AU' => true,
		'en_BE' => true, 'en_BW' => true, 'en_BZ' => true, 'en_CA' => true, 'en_GB' => true,
		'en_GU' => true, 'en_HK' => true, 'en_IE' => true, 'en_IN' => true, 'en_JM' => true,
		'en_MH' => true, 'en_MP' => true, 'en_MT' => true, 'en_NZ' => true, 'en_PH' => true,
		'en_PK' => true, 'en_SG' => true, 'en_TT' => true, 'en_UM' => true, 'en_US' => true,
		'en_VI' => true, 'en_ZA' => true, 'en_ZW' => true, 'en' => true, 'eo' => true,
		'es_AR' => true, 'es_BO' => true, 'es_CL' => true, 'es_CO' => true, 'es_CR' => true,
		'es_DO' => true, 'es_EC' => true, 'es_ES' => true, 'es_GT' => true, 'es_HN' => true,
		'es_MX' => true, 'es_NI' => true, 'es_PA' => true, 'es_PE' => true, 'es_PR' => true,
		'es_PY' => true, 'es_SV' => true, 'es_US' => true, 'es_UY' => true, 'es_VE' => true,
		'es' => true, 'et_EE' => true, 'et' => true, 'eu_ES' => true, 'eu' => true,
		'fa_AF' => true, 'fa_IR' => true, 'fa' => true, 'fi_FI' => true, 'fi' => true,
		'fil' => true, 'fo_FO' => true, 'fo' => true, 'fr_BE' => true, 'fr_CA' => true,
		'fr_CH' => true, 'fr_FR' => true, 'fr_LU' => true, 'fr_MC' => true, 'fr' => true,
		'fur_IT'=> true, 'fur' => true, 'ga_IE' => true, 'ga' => true, 'gaa_GH'=> true,
		'gaa' => true, 'gez_ER'=> true, 'gez_ET'=> true, 'gez' => true, 'gl_ES' => true,
		'gl' => true, 'gu_IN' => true, 'gu' => true, 'gv_GB' => true, 'gv' => true,
		'ha_GH' => true, 'ha_NE' => true, 'ha_NG' => true, 'ha' => true, 'haw_US'=> true,
		'haw' => true, 'he_IL' => true, 'he' => true, 'hi_IN' => true, 'hi' => true,
		'hr_HR' => true, 'hr' => true, 'hu_HU' => true, 'hu' => true, 'hy_AM' => true,
		'hy' => true, 'ia' => true, 'id_ID' => true, 'id' => true, 'ig_NG' => true,
		'ig' => true, 'ii_CN' => true, 'ii' => true, 'is_IS' => true, 'is' => true,
		'it_CH' => true, 'it_IT' => true, 'it' => true, 'iu' => true, 'ja_JP' => true,
		'ja' => true, 'ka_GE' => true, 'ka' => true, 'kaj_NG'=> true, 'kaj' => true,
		'kam_KE'=> true, 'kam' => true, 'kcg_NG'=> true, 'kcg' => true, 'kfo_NG'=> true,
		'kfo' => true, 'kk_KZ' => true, 'kk' => true, 'kl_GL' => true, 'kl' => true,
		'km_KH' => true, 'km' => true, 'kn_IN' => true, 'kn' => true, 'ko_KR' => true,
		'ko' => true, 'kok_IN'=> true, 'kok' => true, 'kpe_GN'=> true, 'kpe_LR'=> true,
		'kpe' => true, 'ku_IQ' => true, 'ku_IR' => true, 'ku_SY' => true, 'ku_TR' => true,
		'ku' => true, 'kw_GB' => true, 'kw' => true, 'ky_KG' => true, 'ky' => true,
		'ln_CD' => true, 'ln_CG' => true, 'ln' => true, 'lo_LA' => true, 'lo' => true,
		'lt_LT' => true, 'lt' => true, 'lv_LV' => true, 'lv' => true, 'mk_MK' => true,
		'mk' => true, 'ml_IN' => true, 'ml' => true, 'mn_MN' => true, 'mn' => true,
		'mr_IN' => true, 'mr' => true, 'ms_BN' => true, 'ms_MY' => true, 'ms' => true,
		'mt_MT' => true, 'mt' => true, 'my_MM' => true, 'my' => true, 'nb_NO' => true,
		'nb' => true, 'ne_NP' => true, 'ne' => true, 'nl_BE' => true, 'nl_NL' => true,
		'nl' => true, 'nn_NO' => true, 'nn' => true, 'nr_ZA' => true, 'nr' => true,
		'nso_ZA'=> true, 'nso' => true, 'ny_MW' => true, 'ny' => true, 'om_ET' => true,
		'om_KE' => true, 'om' => true, 'or_IN' => true, 'or' => true, 'pa_IN' => true,
		'pa_PK' => true, 'pa' => true, 'pl_PL' => true, 'pl' => true, 'ps_AF' => true,
		'ps' => true, 'pt_BR' => true, 'pt_PT' => true, 'pt' => true, 'ro_RO' => true,
		'ro' => true, 'ru_RU' => true, 'ru_UA' => true, 'ru' => true, 'rw_RW' => true,
		'rw' => true, 'sa_IN' => true, 'sa' => true, 'se_FI' => true, 'se_NO' => true,
		'se' => true, 'sh_BA' => true, 'sh_CS' => true, 'sh_YU' => true, 'sh' => true,
		'sid_ET'=> true, 'sid' => true, 'sk_SK' => true, 'sk' => true, 'sl_SI' => true,
		'sl' => true, 'so_DJ' => true, 'so_ET' => true, 'so_KE' => true, 'so_SO' => true,
		'so' => true, 'sq_AL' => true, 'sq' => true, 'sr_BA' => true, 'sr_CS' => true,
		'sr_ME' => true, 'sr_RS' => true, 'sr_YU' => true, 'sr' => true, 'ss_ZA' => true,
		'ss' => true, 'ssy' => true, 'st_ZA' => true, 'st' => true, 'sv_FI' => true,
		'sv_SE' => true, 'sv' => true, 'sw_KE' => true, 'sw_TZ' => true, 'sw' => true,
		'syr_SY'=> true, 'syr' => true, 'ta_IN' => true, 'ta' => true, 'te_IN' => true,
		'te' => true, 'tg_TJ' => true, 'tg' => true, 'th_TH' => true, 'th' => true,
		'ti_ER' => true, 'ti_ET' => true, 'ti' => true, 'tig_ER'=> true, 'tig' => true,
		'tn_ZA' => true, 'tn' => true, 'to_TO' => true, 'to' => true, 'tr_TR' => true,
		'tr' => true, 'ts_ZA' => true, 'ts' => true, 'tt_RU' => true, 'tt' => true,
		'ug' => true, 'uk_UA' => true, 'uk' => true, 'und_ZZ'=> true, 'und' => true,
		'ur_IN' => true, 'ur_PK' => true, 'ur' => true, 'uz_AF' => true, 'uz_UZ' => true,
		'uz' => true, 've_ZA' => true, 've' => true, 'vi_VN' => true, 'vi' => true,
		'wal_ET'=> true, 'wal' => true, 'wo_SN' => true, 'wo' => true, 'xh_ZA' => true,
		'xh' => true, 'yo_NG' => true, 'yo' => true, 'zh_CN' => true, 'zh_HK' => true,
		'zh_MO' => true, 'zh_SG' => true, 'zh_TW' => true, 'zh' => true, 'zu_ZA' => true,
		'zu' => true
	);
	
	private $_recurcivity = 0;
	
	/**
	 * Creer une clef unique en fonction de la valeur
	 * @param string $value
	 * @return string
	 */
	private function _getKey ($value) {
		return strlen($value).'_'.md5($value);
	}
	
	/**
	 * Recherche la traduction de value dans la langue courrante
	 * @param string $value
	 * @param array  $params Paramètre pour remplire les %0, %1, %2... % s'écrira %%
	 * @return string
	 */
	public function get ($value, $params = array ()) {
		
		$lang    = $this->getLang ();
		$country = $this->getCountry();
		$key     = $this->_getKey ($value);
		$result  = NULL;
		$config  = _ioClass ('RaptorConfig');
		
		$this->_recurcivity++;
		if ($this->_recurcivity >= self::MAX_RECURCIVITY) {
			throw new RaptorException ('Problème de base de données sur l\'i18n');
		}
		
		if ($this->_testConnection ()) {
			try {
				$dao = _dao($config->dataTablePrefixe.'_i18n');
				$default = $dao->get (array ($key, self::SYSTEM_LANG, self::SYSTEM_COUNTRY));
				if ($default) {
					$default->last_use = NULL; // Il y a un trigger de maj
					$dao->update ($default);
				} else {
					$record = _record('raptor_i18n');
					$record->id      = $key;
					$record->text    = $value;
					$record->lang    = self::SYSTEM_LANG;
					$record->country = self::SYSTEM_COUNTRY;
					$dao->insert ($record);
				}
				if (($country = '' && $lang == self::SYSTEM_LANG) || ($country = $lang == self::SYSTEM_LANG && $lang == self::SYSTEM_LANG)){
					$result = $value;
				} else {
					// Recherche dans la langue et la contré
					if ($country !== false) {
						$trad = $dao->get (array ($key, $lang, $country));
						if ($trad) {
							$result = $trad->text;
						}
					}

					// Recherche que dans la langue
					if ($result === NULL) {
						$sp = _daoSP()->addCondition('id', '=', $key)
						              ->addCondition('lang', '=', $lang);
						$trads = $dao->findBy ($sp);
						if (count ($trads)) {
							$result = $trads[0]->text;
							if ($country !== false) {
								$record = _record('raptor_i18n');
								$record->id          = $key;
								$record->text        = $value;
								$record->lang        = $lang;
								$record->country     = $country;
								$record->auto_insert = 1;
								$dao->insert ($record);
							}
						}
					}
					// Recherche dans la langue système
					if ($result === NULL) {
						$result = $value;
						if ($country === false) {
							$record = _record('raptor_i18n');
							$record->id          = $key;
							$record->text        = $value;
							$record->lang        = $lang;
							$record->country     = '';
							$record->auto_insert = 1;
							$dao->insert ($record);
						} else {
							$record = _record('raptor_i18n');
							$record->id          = $key;
							$record->text        = $value;
							$record->lang        = $lang;
							$record->country     = $country;
							$record->auto_insert = 1;
							$dao->insert ($record);
						}
					}
				}
			} catch (RaptorException $e) {
				$result = $value;
			}
		} else {
			$result = $value;
		}
		
		if (!is_array($params)){
			$params = array ($params);
		}
		// Remplacement des %
		foreach ($params as $i=>$param) {
			$result = str_replace ('%'.$i, $param, $result);
		}
		
		$this->_recurcivity--;
		
		return $result;
	}
	
	private function _testConnection () {
		
		// TODO erreurnon gerer à réparer
		return false;
		
		if (!RaptorDB::testConnection ()) {
			return false;
		}
		$db = RaptorDB::getConnection ();
		$tables = $db->getTableList ();
		return in_array('raptor_i18n', $tables);
	}
	
	/**
	 * Initialise la langue à utiliser
	 */
	private function _initLocal () {
	
		$arLocal = array ();
		
		$langC = 'null';
		//TODO $langC = RaptorCookie::get('locale', 'null', 'i18n');
		
		$arLocal[] = array ($langC=>1);
		$arLocal[] = self::getBrowserSupportedLanguages ();
		$arLocal[] = self::getEnvironnement ();
		
		// Cherhe la meilleur langue valable
		foreach ($arLocal as $local){
			foreach ($local as $langTotTest=>$quality){
				if ($this->localIsAvailable ($langTotTest)){
					$explode = explode ('_', $langTotTest);
					$lang = $explode[0];
					$country = isset ($explode[0]) ? $explode[0] : '';
					self::$_lang = $lang;
					self::$_country = $country;
					return;
				}
			}
		}
		
		// Si aucune langue n'est valable
		self::$_lang    = self::SYSTEM_LANG;
		self::$_country = self::SYSTEM_COUNTRY;
	}
	
	/**
	 * Retourn la langue courante
	 *
	 * @return string
	 */
	public function getLang () {
		if (self::$_lang === NULL) {
			$this->_initLocal ();
		}
		return self::$_lang;
	}
	
	/**
	 * Retourne le pays courant
	 *
	 * @return string
	 */
	public function getCountry () {
		if (self::$_country === NULL) {
			$this->_initLocal ();
		}
		return self::$_country;
	}
	
	/**
	 * Test si un local est autorisé
	 * @param string $local
	 * @return bool
	 */
	public function localIsAvailable ($local) {
		return isset (self::$_localeData[$local]) && _ioClass ('RaptorConfig')->localIsAvailable ($local);
	}
	
	/**
	 * Définition de la langue à utiliser
	 *
	 * @param string $local    Local à définir
	 * @param bool   $remenber Enregistre dans le cookie
	 * @return bool
	 */
	public function setLocal ($local, $remenber = false) {
		if (!$this->localIsAvailable ($locale)) {
			return false;
		}
		$this->getLangCountryByLocale ($locale, $lang, $country);
		
		self::$_lang = $lang;
		self::$_country = $country;
		if ($remenber) {
			//TODO RaptorCookie::set('locale', $this->getLocale (), 'i18n');
		}
	}
	
	/**
	 * Retourne le couple langue_PAYS demandé
	 *
	 * @param string $lang    Langue dont on veut le couple, si null prend la langue courante
	 * @param string $country Pays dont on veut le couple, si null prend le pays courant
	 * @return string
	 */
	public function getLocale ($lang = null, $country = null) {
		$lang = ($lang === null) ? self::getLang () : $lang;
		$country = ($country === null) ? self::getCountry () : $country;
		// on fait == '' pour prendre le cas de null, et le cas ou on passe réellement un pays vide
		if ($lang == '' && $country == '') {
			return '';
		} else if ($country == '') {
			return $lang;
		} else {
			return $lang.'_'.$country;
		}
	}
	
	/**
	 * Revoie la langue et la contré en fonction du $local
	 * @param string $locale
	 * @param string $lang
	 * @param string $country
	 */
	public function getLangCountryByLocale ($locale, &$lang, &$country){
		if ($locale) {
			$this->localIsAvailable($locale);
			$explode = explode ('_', $locale);
			$pLang = $explode[0];
			$pCountry = isset($explode[1]) ? $explode[1] : '';
		} else {
			$pLang = self::getLang ();
			$pCountry = self::getCountry ();
		}
	}
	
	/**
	 * Récupération des langues supportées par le navigateur internet.
	 *
	 * Cette fonction est fortement inspirée du ZendFramework, dans Zend_Locale
	 *
	 * @return array
	 */
	public static function getBrowserSupportedLanguages (){
		$httplanguages = getenv('HTTP_ACCEPT_LANGUAGE');
		$languages = array();
		if (empty($httplanguages) === true) {
			return $languages;
		}
	
		$accepted = preg_split('/,\s*/', $httplanguages);
	
		foreach ($accepted as $accept) {
			$match = null;
			$result = preg_match('/^([a-z]{1,8}(?:[-_][a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i',
					$accept, $match);
	
			if ($result < 1) {
				continue;
			}
	
			if (isset($match[2]) === true) {
				$quality = (float) $match[2];
			} else {
				$quality = 1.0;
			}
	
			$countrys = explode('-', $match[1]);
			$region = array_shift($countrys);
	
			$country2 = explode('_', $region);
			$region = array_shift($country2);
	
			foreach ($countrys as $country) {
				$languages[$region . '_' . strtoupper($country)] = $quality;
			}
	
			foreach ($country2 as $country) {
				$languages[$region . '_' . strtoupper($country)] = $quality;
			}
	
			if ((isset($languages[$region]) === false) || ($languages[$region] < $quality)) {
				$languages[$region] = $quality;
			}
		}
	
		return $languages;
	}
	
	/**
	 * Récupération des paramètres de langue configurés sur le système.
	 *
	 * Le contenu de cette fonction est fortement inspiré du ZendFramework dans Zend_Locale
	 *
	 * @return array
	 */
	public static function getEnvironnement (){
		$language = setlocale(LC_ALL, 0);
		$languages = explode(';', $language);
		$languagearray = array();
	
		foreach ($languages as $locale) {
			if (strpos($locale, '=') !== false) {
				$language = substr($locale, strpos($locale, '='));
				$language = substr($language, 1);
			}
	
			if ($language !== 'C') {
				if (strpos($language, '.') !== false) {
					$language = substr($language, 0, (strpos($language, '.') - 1));
				} else if (strpos($language, '@') !== false) {
					$language = substr($language, 0, (strpos($language, '@') - 1));
				}
	
				$splitted = explode('_', $language);
				$language = (string) $language;
				if (isset(self::$_localeData[$language]) === true) {
					$languagearray[$language] = 1;
					if (strlen($language) > 4) {
						$languagearray[substr($language, 0, 2)] = 1;
					}
	
					continue;
				}
	
				if (empty(self::$_localeTranslation[$splitted[0]]) === false) {
					if (empty(self::$_localeTranslation[$splitted[1]]) === false) {
						$languagearray[self::$_localeTranslation[$splitted[0]] . '_' .
								self::$_localeTranslation[$splitted[1]]] = 1;
					}
	
					$languagearray[self::$_localeTranslation[$splitted[0]]] = 1;
				}
	
			}
		}
	
		return $languagearray;
	}
	
}