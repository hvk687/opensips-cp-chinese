<?php
/*
 * $Id: pdt.test.inc.php 287 2011-10-17 09:41:35Z untiptun $
 * Copyright (C) 2011 OpenSIPS Project
 *
 * This file is part of opensips-cp, a free Web Control Panel Application for 
 * OpenSIPS SIP server.
 *
 * opensips-cp is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * opensips-cp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

  extract($_POST);
  $form_valid=true;
  if ($form_valid)
   if ($prefix=="") {
                     $form_valid=false;
                     $form_error="- invalid <b>Prefix</b> field -";
                    }
  if ($form_valid)
   if ($domain=="") {
                     $form_valid=false;
                     $form_error="- invalid <b>to Domain</b> field -";
                    }
  if ($form_valid)
   if (!is_numeric($prefix)) {
                              $form_valid=false;
                              $form_error="- <b>Prefix</b> field must be numeric -";
                             }
  if ($form_valid)
   if ($prefix<0) {
                   $form_valid=false;
                   $form_error="- <b>Prefix</b> field must be a positive number -";
                  }
  if ($form_valid) {
                    if ($config->sdomain) $sql="SELECT * FROM ".$table." WHERE prefix='".$config->start_prefix.$prefix."' and sdomain='".$sdomain."'";
                     else $sql="SELECT * FROM ".$table." WHERE prefix='".$config->start_prefix.$prefix."'";
		    $resultset = $link->queryAll($sql); 	
	   	    if(PEAR::isError($resultset)) {
                             die('Failed to issue query, error message : ' . $resultset->getMessage());
                    }
                    $data_rows=count($resultset);
                    if (($config->sdomain) && ($data_rows>0) && (($resultset[0]['prefix']!=$old_prefix) || ($resultset[0]['sdomain']!=$old_sdomain))) $form_valid=false;
                    if ((!$config->sdomain) && ($data_rows>0) && ($resultset[0]['prefix']!=$old_prefix)) $form_valid=false;
                    if (!$form_valid) $form_error="- this is already a valid record -";
                   }

?>
