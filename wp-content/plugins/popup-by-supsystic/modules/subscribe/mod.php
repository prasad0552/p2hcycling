<?php
class subscribePps extends modulePps {
	private $_destList = array();
	public function getDestList() {
		if(empty($this->_destList)) {
			$this->_destList = dispatcherPps::applyFilters('subDestList', array(
				'wordpress' => array('label' => __('WordPress', PPS_LANG_CODE), 'require_confirm' => true),
				'aweber' => array('label' => __('Aweber', PPS_LANG_CODE)),
				'mailchimp' => array('label' => __('MailChimp', PPS_LANG_CODE), 'require_confirm' => true),
				'mailpoet' => array('label' => __('MailPoet', PPS_LANG_CODE), 'require_confirm' => true),
				//'newsletter' => array('label' => __('Newsletter', PPS_LANG_CODE), 'require_confirm' => true),
				'jetpack' => array('label' => __('Jetpack', PPS_LANG_CODE), 'require_confirm' => true),
			));
		}
		return $this->_destList;
	}
	public function getDestByKey($key) {
		$this->getDestList();
		return isset($this->_destList[ $key ]) ? $this->_destList[ $key ] : false;
	}
	public function generateFormStart($popup) {
		$res = '';
		$enbLogin = (isset($popup['params']['tpl']['enb_login']) && !empty($popup['params']['tpl']['enb_login']));
		$enbReg = (isset($popup['params']['tpl']['enb_reg']) && !empty($popup['params']['tpl']['enb_reg']));
		if(($enbLogin || $enbReg)
			&& framePps::_()->getModule('login')
		) {
			if($enbLogin) {
				$res .= framePps::_()->getModule('login')->generateLoginFormStart( $popup );
			}
			if($enbReg && !$enbLogin) {
				$res .= framePps::_()->getModule('login')->generateRegFormStart( $popup );
			}
		} elseif(isset($popup['params']['tpl']['sub_dest']) && !empty($popup['params']['tpl']['sub_dest'])) {
			$subDest = $popup['params']['tpl']['sub_dest'];
			$view = $this->getView();
			$generateMethod = 'generateFormStart_'. $subDest;
			if(method_exists($view, $generateMethod)) {
				$res = $view->$generateMethod( $popup );
			} elseif(framePps::_()->getModule( $subDest ) && method_exists(framePps::_()->getModule( $subDest ), 'generateFormStart')) {
				$res = framePps::_()->getModule( $subDest )->generateFormStart( $popup, $subDest );
			} else {
				$res = $view->generateFormStartCommon( $popup, $subDest );
			}
			$res = dispatcherPps::applyFilters('subFormStart', $res, $popup);
		}
		return $res;
	}
	/**
	 * PopUps have only one submit button - so we wil duplicate it here for both LOgi nand Registration forms
	 * @param array $popup Popup object
	 * @return string Script, that will make duplication of submit button - from Login form to Regstration - if both is enabled
	 */
	private function _addDuplicateRegSubmitBtns( $popup ) {
		return '<script type="text/javascript">'
		. 'jQuery(function(){ '
			. 'var $btns = jQuery("#'. $popup['view_html_id']. '").find(".ppsLoginForm input[type=submit]:not(.ppsPopupClose)").clone();'
			. (isset($popup['params']['tpl']['reg_btn_label']) && !empty($popup['params']['tpl']['reg_btn_label']) 
				? '$btns.attr("value", "'. $popup['params']['tpl']['reg_btn_label']. '");' 
				: '')
			. 'jQuery("#'. $popup['view_html_id']. '").find(".ppsRegForm").append( $btns )'
			. ' });'
		. '</script>';
	}
	public function generateFormEnd($popup) {
		$res = '';
		$enbLogin = (isset($popup['params']['tpl']['enb_login']) && !empty($popup['params']['tpl']['enb_login']));
		$enbReg = (isset($popup['params']['tpl']['enb_reg']) && !empty($popup['params']['tpl']['enb_reg']));
		if(($enbLogin || $enbReg)
			&& framePps::_()->getModule('login')
		) {
			if($enbLogin) {
				$res .= framePps::_()->getModule('login')->generateLoginFormEnd( $popup );
			}
			if($enbReg) {
				if($enbLogin) {
					$res .= framePps::_()->getModule('login')->generateRegFormStart( $popup );
					$res .= framePps::_()->getModule('login')->generateRegFields( $popup );
					$res .= $this->_addDuplicateRegSubmitBtns( $popup );
				}
				$res .= framePps::_()->getModule('login')->generateRegFormEnd( $popup );
			}
		} elseif(isset($popup['params']['tpl']['sub_dest']) && !empty($popup['params']['tpl']['sub_dest'])) {
			$subDest = $popup['params']['tpl']['sub_dest'];
			$view = $this->getView();
			$generateMethod = 'generateFormEnd_'. $subDest;
			if(method_exists($view, $generateMethod)) {
				$res = $view->$generateMethod( $popup );
			} elseif(framePps::_()->getModule( $subDest ) && method_exists(framePps::_()->getModule( $subDest ), 'generateFormEnd')) {
				$res = framePps::_()->getModule( $subDest )->generateFormEnd( $popup );
			} else {
				$res = $view->generateFormEndCommon( $popup );
			}
			$res = dispatcherPps::applyFilters('subFormEnd', $res, $popup);
		}
		return $res;
	}
	public function loadAdminEditAssets() {
		framePps::_()->addScript('admin.subscribe', $this->getModPath(). 'js/admin.subscribe.js');
	}
	public function getAvailableUserRolesForSelect() {
		global $wp_roles;
		$res = array();
		$allRoles = $wp_roles->roles;
		$editableRoles = apply_filters('editable_roles', $allRoles);
		
		if(!empty($editableRoles)) {
			foreach($editableRoles as $role => $data) {
				if(in_array($role, array('administrator', 'editor'))) continue;
				if($role == 'subscriber') {	// Subscriber - at the begining of array
					$res = array($role => $data['name']) + $res;
				} else {
					$res[ $role ] = $data['name'];
				}
			}
		}
		return $res;
	}
	public function generateFields($popup) {
		$resHtml = '';
		$enbLogin = (isset($popup['params']['tpl']['enb_login']) && !empty($popup['params']['tpl']['enb_login']));
		$enbReg = (isset($popup['params']['tpl']['enb_reg']) && !empty($popup['params']['tpl']['enb_reg']));
		if(($enbLogin || $enbReg)
			&& framePps::_()->getModule('login')
		) {
			if($enbLogin) {
				$resHtml .= framePps::_()->getModule('login')->generateLoginFields( $popup );
			}
			if($enbReg && !$enbLogin) {
				$resHtml .= framePps::_()->getModule('login')->generateRegFields( $popup );
			}
		} else {
			foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
				if(isset($f['enb']) && $f['enb']) {
					$htmlType = $f['html'];
					$name = $k;
					// Will not work for now - almost all templates detect it in CSS as [type="text"], and there are no styles for [type="email"]
					if($k == 'email') {
						$htmlType = 'email';
					}
					if($popup && isset($popup['params']) 
						&& isset($popup['params']['tpl']['sub_dest'])
						&& $popup['params']['tpl']['sub_dest'] == 'aweber'
						&& !in_array($name, array('name', 'email'))
						&& strpos($name, 'custom ') !== 0
					) {
						$name = 'custom '. $name;	// This need for aweber to identify custom fields
					}
					if($popup && isset($popup['params']) 
						&& isset($popup['params']['tpl']['sub_dest'])
						&& $popup['params']['tpl']['sub_dest'] == 'arpreach'
						&& in_array($name, array('email'))
					) {
						$name .= '_address';	// name for field email for arpreach should be email_address
					}
					$htmlParams = array(
						'placeholder' => $f['label'],
					);
					if($htmlType == 'selectbox' && isset($f['options']) && !empty($f['options'])) {
						$htmlParams['options'] = array();
						foreach($f['options'] as $opt) {
							$htmlParams['options'][ $opt['name'] ] = isset($opt['label']) ? $opt['label'] : $opt['name'];
						}
					}
					if(isset($f['value']) && !empty($f['value'])) {
						$htmlParams['value'] = $f['value'];
					}
					if(isset($f['mandatory']) && !empty($f['mandatory']) && (int)$f['mandatory']) {
						$htmlParams['required'] = true;
					}
					if(in_array($htmlType, array('checkbox'))) {
						$htmlParams['attrs'] = 'style="height: auto; width: auto; margin: 0; padding: 0;"';
					}
					$inputHtml = htmlPps::$htmlType($name, $htmlParams);
					if($htmlType == 'selectbox') {
						$inputHtml = '<label class="ppsSubSelect"><span class="ppsSubSelectLabel">'. $f['label']. ': </span>'. $inputHtml. '</label>';
					} elseif(in_array($htmlType, array('checkbox'))) {
						$inputHtml = '<label class="ppsSubCheck" style="cursor: pointer;">'. $inputHtml. '&nbsp;'. $f['label']. '</label>';
					}
					$resHtml .= $inputHtml;
				}
			}
		}
		return $resHtml;
	}
}

