<?php
/**
 *  I18n.php
 *
 *  @author     Yoshinari Takaoka <takaoka@beatcraft.com>
 */
namespace Ethnam\Generator\Subcommand;

/**
 *  i18n
 *  generate message catalog.
 *
 *  @author     Yoshinari Takaoka <takaoka@beatcraft.com>
 *  @access     public
 */
class I18n extends Base
{
    /**
     *
     */
    public function perform()
    {
        $r = $this->_getopt(
                  array('basedir=',
                        'locale=',
                        'gettext',
                  )
             );
        if (Ethna::isError($r)) {
            return $r;
        }
        list($opt_list, $arg_list) = $r;

        // basedir
        if (isset($opt_list['basedir'])) {
            $basedir = realpath(end($opt_list['basedir']));
        } else {
            $basedir = getcwd();
        }

        // locale
        if (isset($opt_list['locale'])) {
            $locale = end($opt_list['locale']);
            if (!preg_match('/^[A-Za-z_]+$/', $locale)) {
                return Ethna::raiseError("You specified locale, but invalid : $locale", 'usage');
            }
        } else {
            $locale = 'ja_JP';  //  default locale.
        }

        //  use gettext ?
        $use_gettext = (isset($opt_list['gettext'])) ? true : false;

        //  generate message catalog.
        $ret = Base::generate('I18n', $basedir, $locale, $use_gettext, $arg_list);
        if (Ethna::isError($ret)) {
            printf("error occurred while generating skelton. please see also following error message(s)\n\n");
            return $ret;
        }

        return $ret;
    }

    /**
     *  get handler's description
     *
     *  @access public
     */
    public function getDescription()
    {
        return <<<EOS
generate message catalog of project:
    {$this->id} [-b|--basedir=dir] [-l|--locale=locale] [-g|--gettext] [extdir1] [extdir2] ...

EOS;
    }

    /**
     *  @access public
     */
    public function getUsage()
    {
        return <<<EOS
ethna {$this->id} [-b|--basedir=dir] [-l|--locale=locale] [-g|--gettext] [extdir1] [extdir2] ...

EOS;
    }
}
// }}}
