<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="Tiara" />
    <style type="text/css">
      html {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 11pt;
        background-color: white
      }

      a.comment-indicator:hover+div.comment {
        background: #ffd;
        position: absolute;
        display: block;
        border: 1px solid black;
        padding: 0.5em
      }

      a.comment-indicator {
        background: red;
        display: inline-block;
        border: 1px solid black;
        width: 0.5em;
        height: 0.5em
      }

      div.comment {
        display: none
      }

      table {
        border-collapse: collapse;
        page-break-after: always
      }

      .gridlines td {
        border: 1px dotted black
      }

      .gridlines th {
        border: 1px dotted black
      }

      .b {
        text-align: center
      }

      .e {
        text-align: center
      }

      .f {
        text-align: right
      }

      .inlineStr {
        text-align: left
      }

      .n {
        text-align: right
      }

      .s {
        text-align: left
      }

      @page {
        size: A4;
        margin: 0;
      }

      td.style0 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style0 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style1 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style1 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style2 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style2 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style3 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style3 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style4 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style4 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style5 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 22pt;
        background-color: white
      }

      th.style5 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 22pt;
        background-color: white
      }

      td.style6 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style6 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style7 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style7 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style8 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style8 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style9 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style9 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style10 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 22pt;
        background-color: white
      }

      th.style10 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 22pt;
        background-color: white
      }

      td.style11 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      th.style11 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      td.style12 {
        vertical-align: middle;
        text-align: center;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      th.style12 {
        vertical-align: middle;
        text-align: center;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      td.style13 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      th.style13 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      td.style14 {
        vertical-align: bottom;
        text-align: center;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      th.style14 {
        vertical-align: bottom;
        text-align: center;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 12pt;
        background-color: white
      }

      td.style15 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style15 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style16 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        text-decoration: underline;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style16 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        text-decoration: underline;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style17 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style17 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style18 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style18 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style19 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style19 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style20 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style20 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style21 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style21 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style22 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style22 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style23 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style23 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style24 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style24 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style25 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style25 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style26 {
        vertical-align: top;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style26 {
        vertical-align: top;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style27 {
        vertical-align: top;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style27 {
        vertical-align: top;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style28 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style28 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style29 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style29 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style30 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style30 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style31 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style31 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style32 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style32 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style33 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style33 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style34 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style34 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style35 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: #FFFFFF
      }

      th.style35 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: #FFFFFF
      }

      td.style36 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style36 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style37 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style37 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style38 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style38 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style39 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style39 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style40 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style40 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style41 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style41 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style42 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style42 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style43 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style43 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style44 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style44 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style45 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style45 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style46 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style46 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style47 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style47 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style48 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style48 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style49 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style49 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style50 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style50 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style51 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style51 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style52 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style52 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style53 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style53 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style54 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style54 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style55 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style55 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style56 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style56 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style57 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style57 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style58 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style58 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style59 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style59 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style60 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style60 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style61 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style61 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style62 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style62 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style63 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style63 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style64 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style64 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style65 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style65 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style66 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style66 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style67 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style67 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style68 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style68 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style69 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style69 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style70 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style70 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style71 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style71 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style72 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style72 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style73 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style73 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style74 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style74 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style75 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style75 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style76 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style76 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style77 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style77 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style78 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style78 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style79 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style79 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style80 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style80 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style81 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style81 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style82 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style82 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style83 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style83 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style84 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style84 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style85 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style85 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style86 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style86 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style87 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style87 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style88 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style88 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style89 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style89 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style90 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style90 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style91 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style91 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style92 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style92 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style93 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style93 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style94 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style94 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style95 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style95 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style96 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style96 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style97 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style97 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 2px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style98 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style98 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style99 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style99 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style100 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style100 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style101 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        text-decoration: underline;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style101 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        text-decoration: underline;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style102 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        text-decoration: underline;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style102 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        text-decoration: underline;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style103 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style103 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style104 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style104 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style105 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        text-decoration: underline;
        font-style: italic;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style105 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        text-decoration: underline;
        font-style: italic;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style106 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 8pt;
        background-color: #FFFFFF
      }

      th.style106 {
        vertical-align: bottom;
        text-align: right;
        padding-right: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 8pt;
        background-color: #FFFFFF
      }

      td.style107 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style107 {
        vertical-align: bottom;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style108 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style108 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style109 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style109 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style110 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style110 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 2px solid #000000 !important;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style111 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style111 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style112 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style112 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style113 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style113 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style114 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style114 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style115 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style115 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style116 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style116 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style117 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style117 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style118 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      th.style118 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 9pt;
        background-color: white
      }

      td.style119 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style119 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style120 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style120 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style121 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style121 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: 2px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style122 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style122 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style123 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style123 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style124 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style124 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style125 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style125 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 2px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style126 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style126 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style127 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style127 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style128 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style128 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style129 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style129 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style130 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style130 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style131 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style131 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style132 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style132 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style133 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style133 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style134 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style134 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style135 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style135 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style136 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style136 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 2px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      td.style137 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      th.style137 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Calibri';
        font-size: 11pt;
        background-color: white
      }

      table.sheet0 col.col0 {
        width: 11.52222209pt
      }

      table.sheet0 col.col1 {
        width: 67.09999923pt
      }

      table.sheet0 col.col2 {
        width: 9.48888878pt
      }

      table.sheet0 col.col3 {
        width: 61.67777707pt
      }

      table.sheet0 col.col4 {
        width: 94.8888878pt
      }

      table.sheet0 col.col5 {
        width: 66.42222146pt
      }

      table.sheet0 col.col6 {
        width: 69.13333254pt
      }

      table.sheet0 col.col7 {
        width: 66.42222146pt
      }

      table.sheet0 col.col8 {
        width: 35.92222181pt
      }

      table.sheet0 col.col9 {
        width: 25.75555526pt
      }

      table.sheet0 col.col10 {
        width: 25.75555526pt
      }

      table.sheet0 col.col11 {
        width: 68.45555477pt
      }

      table.sheet0 col.col12 {
        width: 42pt
      }

      table.sheet0 col.col13 {
        width: 42pt
      }

      table.sheet0 col.col14 {
        width: 42pt
      }

      table.sheet0 tr {
        height: 15pt
      }

      table.sheet0 tr.row0 {
        height: 15pt
      }

      table.sheet0 tr.row1 {
        height: 15pt
      }

      table.sheet0 tr.row2 {
        height: 15.75pt
      }

      table.sheet0 tr.row3 {
        height: 15.75pt
      }

      table.sheet0 tr.row5 {
        height: 14.25pt
      }

      table.sheet0 tr.row6 {
        height: 12pt
      }

      table.sheet0 tr.row8 {
        height: 15.75pt
      }

      table.sheet0 tr.row10 {
        height: 15pt
      }

      table.sheet0 tr.row19 {
        height: 15.75pt
      }

      table.sheet0 tr.row20 {
        height: 15.75pt
      }

      table.sheet0 tr.row21 {
        height: 15.75pt
      }

      table.sheet0 tr.row22 {
        height: 15.75pt
      }

      table.sheet0 tr.row23 {
        height: 15.75pt
      }

      table.sheet0 tr.row24 {
        height: 15.75pt
      }

      table.sheet0 tr.row25 {
        height: 15.75pt
      }

      table.sheet0 tr.row26 {
        height: 15.75pt
      }

      table.sheet0 tr.row27 {
        height: 6pt
      }

      table.sheet0 tr.row28 {
        height: 15.75pt
      }

      table.sheet0 tr.row29 {
        height: 15.75pt
      }

      table.sheet0 tr.row30 {
        height: 15.75pt
      }

      table.sheet0 tr.row31 {
        height: 15.75pt
      }

      table.sheet0 tr.row32 {
        height: 15.75pt
      }

      table.sheet0 tr.row33 {
        height: 15.75pt
      }

      table.sheet0 tr.row34 {
        height: 15.75pt
      }

      table.sheet0 tr.row35 {
        height: 15.75pt
      }

      table.sheet0 tr.row36 {
        height: 15.75pt
      }

      table.sheet0 tr.row37 {
        height: 15.75pt
      }

      table.sheet0 tr.row38 {
        height: 15.75pt
      }

      table.sheet0 tr.row39 {
        height: 15.75pt
      }

      table.sheet0 tr.row40 {
        height: 15.75pt
      }

      table.sheet0 tr.row41 {
        height: 12pt
      }

      table.sheet0 tr.row42 {
        height: 12pt
      }

      table.sheet0 tr.row43 {
        height: 12pt
      }

      table.sheet0 tr.row44 {
        height: 12pt
      }
    </style>
  </head>
  <body>
    <style>
      body {
        margin-left: 0in;
        margin-right: 0in;
        margin-top: 0in;
        margin-bottom: 0.75in;
      }
    </style>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
      <col class="col0">
      <col class="col1">
      <col class="col2">
      <col class="col3">
      <col class="col4">
      <col class="col5">
      <col class="col6">
      <col class="col7">
      <col class="col8">
      <col class="col9">
      <col class="col10">
      <col class="col11">
      <col class="col12">
      <col class="col13">
      <col class="col14">
      <tbody>
        <tr class="row0">
          <td class="column1">&nbsp;</td>
          <td class="column2">&nbsp;</td>
          <td class="column3">&nbsp;</td>
          <td class="column4">&nbsp;</td>
          <td class="column5">&nbsp;</td>
          <td class="column6">&nbsp;</td>
          <td class="column7">&nbsp;</td>
          <td class="column8">&nbsp;</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
        </tr>
        <tr class="row1">
          <td class="column1 style2 null">
            <div style="position: relative;">
              <img style="position: absolute; z-index: 1; left: 20px; top: 5px; width: 70px; height: 80px;" src="{{ url('/upload/spa.png') }}" border="0" />
            </div>
          </td>
          <td class="column2 style3 null"></td>
          <td class="column3 style3 null"></td>
          <td class="column4 style4 null"></td>
          <td class="column5 style5 null"></td>
          <td class="column6 style4 null"></td>
          <td class="column7 style4 null"></td>
          <td class="column8 style6 null" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row2">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style10 s style10" colspan="6" rowspan="2">KONTRAK</td>
          <td class="column6 style137 s" style="width: 69px">No Kontrak</td>
          <td class="column7 style11 s style12" colspan="2">{{ $kontrak_M->kode }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row3">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column6 style137 s">PO</td>
          <td class="column7 style13 s style14" colspan="2">{{ $kontrak_M->poCustomer }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row4">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style9 null"></td>
          <td class="column5 style9 null"></td>
          <td class="column6 style9 null"></td>
          <td class="column7 style9 null"></td>
          <td class="column8 style15 null" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row5">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style9 null"></td>
          <td class="column5 style9 null"></td>
          <td class="column6 style9 null"></td>
          <td class="column7 style9 null"></td>
          <td class="column8 style15 null" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row6">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style9 null"></td>
          <td class="column5 style9 null"></td>
          <td class="column6 style16 null style18" colspan="7"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row7">
          <td class="column1 style19 s">CUSTOMER</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style21 s style22" colspan="10">{{ $kontrak_M->customer_name }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row8">
          <td class="column1 style8 s" style="width: 100px">ALAMAT KIRIM</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style23 s style24" colspan="10">{{ $kontrak_M->alamatKirim }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row9">
          <td class="column1 style19 s">TELP / FAX</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style23 s style23" colspan="2">{{ $kontrak_M->custTelp }}</td>
          <td class="column5 style9 null"></td>
          <td class="column6 style25 s"></td>
          <td class="column6 style25 s"></td>
          <td class="column6 style25 s"></td>
          <td class="column7 style25 s" colspan="2">TIPE ORDER</td>
          <td class="column8 style135 s style136" colspan="2">{{ $kontrak_M->tipeOrder }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row10">
          <td class="column1 style26 s">KETERANGAN</td>
          <td class="column2 style27 null"></td>
          <td class="column9 style28 s " colspan="5">{{ $kontrakBox->keterangan }}</td>
          <td class="column3 style28 s style29" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row11">
          <td class="column1 style30 s style32" colspan="12">BOX</td>
          <td class="column13 style33 null"></td>
          <td class="column14 style33 null"></td>
        </tr>
        <tr class="row12">
          <td class="column1 style34 s">Item</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style35 s style35" colspan="3">{{ $kontrakBox->Barang }}</td>
          <td class="column2 style20 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column6 style36 s" colspan="3">Jumlah Order</td>
          <td class="column7 style132 n style133" colspan="2">{{ $kontrakBox->pcsKontrak }} </td>
          <td class="column9 style7 null"></td>
          <td class="column11 style20 null"></td>
          <td class="column13 style37 null"></td>
          <td class="column14 style37 null"></td>
        </tr>
        <tr class="row13">
          <td class="column1 style34 s">Kualitas</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style23 s style23" colspan="3">{{ $kontrakBox->substance }}</td>
          <td class="column2 style20 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column6 style36 s" colspan="3">Toleransi</td>
          <td class="column7 style128 n style129" colspan="2">{{ $kontrakBox->pctToleransiLebihKontrak }}%</td>
        </tr>
        <tr class="row14">
          <td class="column1 style34 s">Warna</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style23 s style23" colspan="3">{{ $kontrakBox->warna }}</td>
          <td class="column2 style20 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column6 style36 s" colspan="3">TOP</td>
          <td class="column7 style130 s style131" colspan="2">{{ $kontrak_M->top }}</td>
        </tr>
        <tr class="row15">
          <td class="column1 style34 s">Ukuran</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style23 s style23" colspan="3">{{ $kontrakBox->panjangSheetBox }} x {{ $kontrakBox->lebarSheetBox }} x 1</td>
          <td class="column2 style20 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column6 style36 s" colspan="3">Wax</td>
          <td class="column7 style23 s style24" colspan="2">{{ $kontrakBox->wax }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row16">
          <td class="column1 style34 s">Harga</td>
          <td class="column2 style20 null"></td>
          <td class="column3 style134 n">{{ $kontrakBox->harga_pcs }} </td>
          <td class="column4 style21 s style21" colspan="2">Exclude PPN</td>
          <td class="column2 style20 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column6 style38 s" colspan="3">TIPE CREASE</td>
          <td class="column7 style23 s style24" colspan="2">{{ $kontrakBox->tipeCrease }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row17">
          <td class="column1 style34 s">Flute</td>
          <td class="column2 style39 null"></td>
          <td class="column3 style23 s style23" colspan="3">{{ $kontrakBox->flute }}</td>
          <td class="column2 style39 null"></td>
          <td class="column2 style39 null"></td>
          <td class="column6 style38 s" colspan="3">JOIN</td>
          <td class="column7 style23 s style24" colspan="2">{{ $kontrakBox->joint }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row18">
          <td class="column1 style19 s">Bentuk</td>
          <td class="column2 style39 null"></td>
          <td class="column3 style23 s style23" colspan="3">{{ $kontrakBox->tipeBox }}</td>
          <td class="column2 style39 null"></td>
          <td class="column2 style39 null"></td>
          <td class="column6 style9 s" colspan="3">Bungkus</td>
          <td class="column7 style23 s style24" colspan="2">{{ $kontrakBox->bungkus }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row19">
          <td class="column1 style40 s">Packing</td>
          <td class="column2 style41 null"></td>
          <td class="column3 style42 s style42" colspan="3">{{ $kontrakBox->koli }} BOX / COLLY</td>
          <td class="column6 style43 null"></td>
          <td class="column7 style43 null"></td>
          <td class="column8 style44 null" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row20">
          <td class="column1 style45 s style47" colspan="12">PELENGKAP</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row21">
          <td class="column1 style48 s style49" colspan="2">JENIS</td>
          <td class="column3 style50 s" colspan="2">UKURAN</td>
          <td class="column4 style49 s style49" colspan="4">KUALITAS</td>
          <td class="column6 style50 s" colspan="2">FLUTE</td>
          <td class="column7 style49 s style51" colspan="2">QTY</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr> @foreach ($kontrak_D as $data) <tr class="row22">
          <td class="column1 style52 s style53" colspan="2">{{ $data->tipe }}</td>
          <td class="column3 style54 s" colspan="2">{{ $data->panjangSheetBox }} x {{ $data->lebarSheetBox }}</td>
          <td class="column4 style55 s style55" colspan="4">{{ $data->substance }}</td>
          <td class="column6 style56 s" colspan="2">{{ $data->flute }}</td>
          <td class="column7 style57 n style58" colspan="2">{{ $data->pcsKontrak }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr> @endforeach <tr class="row27">
          <td class="column1 style73 null"></td>
          <td class="column2 style74 null"></td>
          <td class="column3 style75 null"></td>
          <td class="column4 style74 null"></td>
          <td class="column5 style74 null"></td>
          <td class="column6 style74 null"></td>
          <td class="column7 style76 null"></td>
          <td class="column8 style77 null" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row28">
          <td class="column1 style78 s style79" colspan="2">Tanggal Kirim</td>
          <td class="column3 style80 s" colspan="2">Qty</td>
          <td class="column4 style81 s" colspan="2">Tanggal Kirim</td>
          <td class="column5 style80 s" colspan="2">Qty</td>
          <td class="column6 style81 s" colspan="2">Tanggal Kirim</td>
          <td class="column7 style82 s style83" colspan="2">Qty</td>
          <td class="column9 style7 null"></td>
          <td class="column10">&nbsp;</td>
        </tr> @foreach ($dt as $data) <tr class="row29">
          <td class="column1 style84 s style85" colspan="2">{{ $data->tglKirimDt }}</td>
          {{-- <td class="column3 style86 n" colspan="2">{{ $data->pcsDt }}</td>
          <td class="column4 style87 s" colspan="2">{{ $data->tglKirimDt }}</td>
          <td class="column5 style86 n" colspan="2">{{ $data->pcsDt }}</td>
          <td class="column6 style88 s" colspan="2">{{ $data->tglKirimDt }}</td> --}} <td class="column7 style89 n style90" colspan="2">{{ $data->pcsDt }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr> @endforeach <tr class="row33">
          <td class="column1 style98 s style99" colspan="3">Hormat Kami,</td>
          <td class="column4 style4 null"></td>
          <td class="column5 style4 null"></td>
          <td class="column5 style4 null"></td>
          <td class="column5 style4 null"></td>
          <td class="column5 style4 null"></td>
          <td class="column6 style100 s style100" colspan="3">Disetujui Oleh,</td>
          <td class="column8 style6 null"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row34">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style9 null"></td>
          <td class="column5 style9 null"></td>
          <td class="column6 style9 null"></td>
          <td class="column7 style9 null"></td>
          <td class="column8 style15 null" colspan="3"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row35">
          <td class="column1 style8 null"></td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style9 null"></td>
          <td class="column5 style9 null"></td>
          <td class="column6 style9 null"></td>
          <td class="column6 style9 null"></td>
          <td class="column7 style9 null"></td>
          <td class="column8 style15 null" colspan="4"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row36">
          <td class="column1 style101 s style102" colspan="3">{{ $kontrak_M->sales }}</td>
          <td class="column4 style39 null"></td>
          <td class="column5 style39 null"></td>
          <td class="column4 style39 null"></td>
          <td class="column5 style39 null"></td>
          <td class="column4 style39 null"></td>
          <td class="column5 style39 null"></td>
          <td class="column6 style103 s style104" colspan="2">(.............................................)</td>
          <td class="column8 style15 null"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row37">
          <td class="column1 style105 s">Keterangan :</td>
          <td class="column2 style9 null"></td>
          <td class="column3 style9 null"></td>
          <td class="column4 style9 null"></td>
          <td class="column5 style9 null"></td>
          <td class="column6 style9 null"></td>
          <td class="column7 style9 null"></td>
          <td class="column8 style15 null" colspan="5"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row38">
          <td class="column1 style125 s style127" colspan="12">- Pembayaran dapat ditransfer ke</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row39">
          <td class="column1 style122 s style124" colspan="12">&nbsp;&nbsp;Maybank 250 808 9999 atas nama PT Sarana Packaging Agrapana</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row40">
          <td class="column1 style119 s style121" colspan="12">- Kontrak ini bersifat mengikat dan merupakan tanda bukti yang sah</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row41">
          <td class="column1 style108 s style110" colspan="12">PT. Sarana Packaging Agrapana</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row42">
          <td class="column1 style111 s style113" colspan="12">Office: JL. Imam Bonjol 101, RT 004 RW 001, Surabaya 62064</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row43">
          <td class="column1 style114 s style116" colspan="12">Factory: JL Raya Lamongan-Mantup Km. 16,4, Kedungsari, Kembangbahu, Ds Moronyamplung, Kab. Lamongan 62282</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
        <tr class="row44">
          <td class="column1 style117 s style118" colspan="6">Email : marketing@saranapackaging.com</td>
          <td class="column7 style106 f style107" colspan="6">{{ date("d-m-Y h:i:s") }}</td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>