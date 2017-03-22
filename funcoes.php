<?php

function response($type = 'success', $data = array())
   {
      $return = '';

      switch ($type):
         case 'success':
            $resp = array('info' => 1);
            break;
         case 'error':
            $resp = array('info' => 0);
            break;
         case 'missing':
            set_status_header(410);
            $data = is_string($data) ? $data : '';
            $resp = $data;
            break;
      endswitch;

      if (is_array($data)) {
         unset($data['info']);

         if (count($data)) {
            $return = json_encode(array_merge($resp, $data));
         } else {
            if (isset($resp)):
               $return = json_encode($resp);
            else:
               if (is_array($type)):
                  $return = json_encode($type);
               else:
                  $return = $type;
               endif;
            endif;
         }
      } else {
         $return = $data;
      }
      exit($return);
   }
   ?>
