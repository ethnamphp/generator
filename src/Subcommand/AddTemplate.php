<?php
/**
 *  AddTemplate.php
 *
 *  @author     nnno <nnno@nnno.jp>
 */
namespace Ethnam\Generator\Subcommand;

/**
 *  add-template handler
 *
 *  @author     nnno <nnno@nnno.jp>
 *  @access     public
 */
class AddTemplate extends AddView
{
    /**
     *
     */
    public function perform()
    {
        $r = $this->_getopt(
                  array('basedir=',
                        'skelfile=',
                        'locale=',
                        'encoding=',
                  )
              );
        if (Ethna::isError($r)) {
            return $r;
        }
        list($opt_list, $arg_list) = $r;

        // template
        $template = array_shift($arg_list);
        if ($template == null) {
            return Ethna::raiseError('template name isn\'t set.', 'usage');
        }
        $r = Ethna_Controller::checkViewName($template); // XXX: use checkViewName().
        if (Ethna::isError($r)) {
            return $r;
        }

        // add template
        $ret = $this->_performTemplate($template, $opt_list);
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
add new template to project:
    {$this->id} [-b|--basedir=dir] [-s|--skelfile=file] [-l|--locale=locale] [-e|--encoding] [template]

EOS;
    }

    /**
     *  @access public
     */
    public function getUsage()
    {
        return <<<EOS
ethna {$this->id} [-b|--basedir=dir] [-s|--skelfile=file] [-l|--locale=locale] [-e|--encoding] [template]
EOS;
    }
}
// }}}
