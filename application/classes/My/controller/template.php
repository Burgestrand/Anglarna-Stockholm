<?php defined('SYSPATH') OR die('No direct access allowed.');
     /**
      * @category    Controllers
      * @author      Kim Burgestrand <kim@burgestrand.se>
      * @license     <http://www.gnu.org/licenses/lgpl-3.0.txt> LGPL v3
      */
     class My_Controller_Template extends Controller_Template
     {
         public function before()
         {
             parent::before();
             $this->template->title   = '';
             $this->template->content = '';
         }
         
         public function after()
         {
             if (Request::$is_ajax)
             {
                 $this->request->response = $this->template->content;
             }
             else
             {
                 parent::after();
             }
         }
     }

/* End of file controller.php */
/* Location: ./application/classes/My/controller.php */ 