<?php namespace BaunPlugin\DynamicSections;

use Baun\Plugin;

class DynamicSections extends Plugin {

  public function init()
  {
    $this->events->addListener('baun.beforePageRender', [$this, 'beforePageRender']);
    $this->events->addListener('baun.beforeDispatch', [$this, 'beforeDispatch']);
    $this->events->addListener('baun.afterSetupRoutes', [$this, 'setupRoutes']);

    $this->theme->addPath(dirname(__DIR__) . '/templates');
  }

  public function setupRoutes()
  {
    $this->router->group(['before' => ['csrf', 'users', 'auth']], function(){
      $this->router->add('GET',  '/admin/pages/ajax/add-section', [$this, 'routeAjaxAddSection']);
    });
  }

  public function routeAjaxAddSection()
  {
    if ($_GET['template'] == '' OR $_GET['num'] == '') {
      return '';   // TODO: return error code
    }
    $template = $_GET['template'];
    $data['count'] = $_GET['num'] + 1;
    $html = $this->theme->render($template, $data);
    $html = $html . '<div id="section-replace"></div>';

    return $html;
  }

  public function beforePageRender ($template, $data)
  {

    $z = '<pre>';
      $z .= print_r($data['info']['page_sections'], 1);
      $z .= '</pre>';
      print $z;
      print 'END<br><br>';

    /*if ($data['info']['page_sections']) {
      try{
        $data['info']['page_sections'] = $this->transformToMarkdown($data['info']['page_sections'] , 1);
        // Need to recursively step through all the page_sections arrays and convert any content to
        // $data['page_sections'][0]['block'] = '';
        // $data['page_sections'][0]['content']
        // $data['page_sections'][1]['col1']['content']
        // $data['page_sections'][1]['col2']['content']
        // $data['page_sections'][1]['col3']['content']
      } catch(\Exception $e) {}
    }*/

 /*    $z = '<pre>';
      $z .= print_r($data['info']['page_sections'], 1);
      $z .= '</pre>';
      print $z;*/
  }

  public function beforeDispatch()
  {


  }


  /*private function transformToMarkdown($array, $level)
  {

    foreach ($array as $key => $value) {

      //print  $level . ' - ' . $key . ' - ' . $value . '<br>';

      foreach($value as $key1 => $value1) {

        // print  $level + 1 . ' - ' . $key1 . ' - ' . $value1 . '<br>';

        if (trim($key1) == 'content') {
          $array[$key][$key1] = MarkdownExtra::defaultTransform($value1);
          // print '$k == content ' . $v . '<br>';
        }
        elseif (is_array($v)) {
          print  'Next level <br>';

          foreach ($value1 as $key2 => $value2) {
            if (trim($key2) == 'content') {
              $array[$key][$key1][$key2] = MarkdownExtra::defaultTransform($value2);
            }

          }
          //$array[$key][$k] = $this->transformToMarkdown($v, $level + 1);
        }
      }
    }


  return $array;
  }*/


    /*private function sectionTemplates()
  {
    return [
      'admin-ds-one-column' => 'One Column',
      'admin-ds-two-column' => 'Two Columns',
      'admin-ds-three-column' => 'Three Columns',
    ];
  }*/
  //$data['section_templates'] = $this->sectionTemplates();


}