<?php
/**
 * This file is part of student-sen-info.
 *
 * student-sen-info is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * student-sen-info is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with student-sen-info.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Jonathan Hart
 */

/**
 * Header page to load all of the HTML head code
 */
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="//storage.googleapis.com/code.getmdl.io/1.0.5/material.indigo-blue.min.css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animsition/3.5.2/css/animsition.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.1.2/css/material-design-iconic-font.min.css">
		<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
		<link rel="stylesheet" href="styles.css">

		<title>SEN Info</title>

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	</head>
	<body>
	<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--primary mdl-color--grey-100">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">SEN Info</span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-button--icon" id="button--show-search" style="display: none;">
			  <i class="material-icons">search</i>
			</button>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn" style="display: none;">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item" id="button--logout">Logout</li>
          </ul>
        </div>
      </header>
      <main class="mdl-layout__content mdl-color--grey-100">