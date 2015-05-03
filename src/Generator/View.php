<?php
/**
 *  View.php
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 */
namespace Ethnam\Generator\Generator;

use Ethna_Util;

/**
 *  スケルトン生成クラス
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @access     public
 */
class View extends Base
{
    /**
     *  ビューのスケルトンを生成する
     *
     *  @access public
     *  @param  string  $forward_name   ビュー名
     *  @param  string  $skelton        スケルトンファイル名
     *  @return true|Ethna_Error        true:成功 Ethna_Error:失敗
     */
    public function generate($forward_name, $skelton = null, $gateway = GATEWAY_WWW)
    {
        $view_dir = $this->ctl->getViewdir();
        $view_class = $this->ctl->getDefaultViewClass($forward_name, $gateway);
        $view_path = $this->ctl->getDefaultViewPath($forward_name);

        // entity
        $entity = $view_dir . $view_path;
        Ethna_Util::mkdir(dirname($entity), 0755);

        // skelton
        if ($skelton === null) {
            $skelton = 'skel.view.php';
        }

        // macro
        $macro = array();
        $macro['project_id'] = $this->ctl->getAppId();
        $macro['forward_name'] = $forward_name;
        $macro['view_class'] = $view_class;
        $macro['view_path'] = $view_path;

        // user macro
        $user_macro = $this->_getUserMacro();
        $macro = array_merge($macro, $user_macro);


        // generate
        if (file_exists($entity)) {
            printf("file [%s] already exists -> skip\n", $entity);
        } elseif ($this->_generateFile($skelton, $entity, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $entity);
        } else {
            printf("view script(s) successfully created [%s]\n", $entity);
        }

        $true = true;
        return $true;
    }
}
// }}}
