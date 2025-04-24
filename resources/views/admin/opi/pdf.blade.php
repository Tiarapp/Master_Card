<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="Tiar" />
    <style type="text/css">
      html {
        font-family: Times New Roman, Arial, Helvetica, sans-serif;
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

      td.style0 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
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
        font-family: 'Times New Roman';
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
        font-family: 'Times New Roman';
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
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style2 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style2 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style3 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style3 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style4 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style4 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style5 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style5 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style6 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style6 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style7 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style7 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style8 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style8 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style9 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style9 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style10 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style10 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style11 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style11 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style12 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style12 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style13 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style13 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style14 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style14 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style15 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style15 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style16 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style16 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style17 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style17 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style18 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style18 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style19 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      th.style19 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      td.style20 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style20 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style21 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style21 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style22 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style22 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style23 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      th.style23 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      td.style24 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      th.style24 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      td.style25 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      th.style25 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 21pt;
        background-color: white
      }

      td.style26 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 10pt;
        background-color: white
      }

      th.style26 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 10pt;
        background-color: white
      }

      td.style27 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style27 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style28 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style28 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style29 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      th.style29 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 11pt;
        background-color: white
      }

      td.style30 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style30 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style31 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style31 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style32 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style32 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style33 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style33 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style34 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style34 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style35 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style35 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style36 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style36 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style37 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: #FFFFFF
      }

      th.style37 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: #FFFFFF
      }

      td.style38 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style38 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style39 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style39 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style40 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style40 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style41 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style41 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style42 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style42 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style43 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style43 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style44 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style44 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style45 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style45 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style46 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style46 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style47 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style47 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style48 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style48 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style49 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style49 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style50 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style50 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style51 {
        vertical-align: top;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style51 {
        vertical-align: top;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style52 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #FFFFFF;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: #FFFFFF
      }

      th.style52 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #FFFFFF;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: #FFFFFF
      }

      td.style53 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style53 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style54 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style54 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style55 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style55 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style56 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style56 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style57 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style57 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style58 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style58 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style59 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style59 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style60 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: #FFFFFF
      }

      th.style60 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: #FFFFFF
      }

      td.style61 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style61 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style62 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style62 {
        vertical-align: top;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style63 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 14pt;
        background-color: white
      }

      th.style63 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 14pt;
        background-color: white
      }

      td.style64 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 14pt;
        background-color: white
      }

      th.style64 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 14pt;
        background-color: white
      }

      td.style65 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      th.style65 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      td.style66 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      th.style66 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      td.style67 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      th.style67 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      td.style68 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      th.style68 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: '"Times New Roman"';
        font-size: 14pt;
        background-color: white
      }

      td.style69 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style69 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      td.style70 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style70 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style71 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      th.style71 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 26pt;
        background-color: white
      }

      td.style72 {
        vertical-align: top;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      th.style72 {
        vertical-align: top;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Times New Roman';
        font-size: 21pt;
        background-color: white
      }

      table.sheet0 col.col0 {
        /* width: 18.97777756pt */
        width: 100pt;
      }

      table.sheet0 col.col1 {
        width: 75.23333247pt
      }

      table.sheet0 col.col2 {
        /* width: 92.17777672pt */
        width: 100pt;
      }

      table.sheet0 col.col3 {
        /* width: 79.29999909pt */
        width: 100pt;
      }

      table.sheet0 col.col4 {
        /* width: 71.16666585pt */
        width: 100pt;
      }

      table.sheet0 col.col5 {
        /* width: 81.3333321pt */
        width: 100pt;
      }

      table.sheet0 col.col6 {
        /* width: 86.07777679pt */
        width: 130pt;
      }

      table.sheet0 col.col7 {
        width: 170pt
      }

      table.sheet0 col.col8 {
        width: 110.41110989pt
      }

      table.sheet0 col.col9 {
        /* width: 75.91111021pt */
        width: 100pt;
      }

      table.sheet0 col.col10 {
        /* width: 86.07777679pt */
        width: 100pt;
      }

      table.sheet0 col.col11 {
        width: 62.35555484pt
      }

      table.sheet0 tr {
        height: 15pt
      }

      table.sheet0 tr.row0 {
        height: 26.25pt
      }

      table.sheet0 tr.row1 {
        height: 27pt
      }

      table.sheet0 tr.row2 {
        height: 27.75pt
      }

      table.sheet0 tr.row3 {
        height: 23.25pt
      }

      table.sheet0 tr.row4 {
        height: 23.25pt;
        display: none;
        visibility: hidden
      }

      table.sheet0 tr.row5 {
        height: 23.25pt
      }

      table.sheet0 tr.row6 {
        height: 31.5pt
      }

      table.sheet0 tr.row7 {
        height: 21pt
      }

      table.sheet0 tr.row8 {
        height: 23.25pt
      }

      table.sheet0 tr.row9 {
        height: 23.25pt
      }

      table.sheet0 tr.row10 {
        height: 23.25pt
      }

      table.sheet0 tr.row11 {
        height: 60pt
      }

      table.sheet0 tr.row12 {
        height: 23.25pt
      }

      table.sheet0 tr.row13 {
        height: 25.5pt
      }

      table.sheet0 tr.row14 {
        height: 27.75pt
      }

      table.sheet0 tr.row15 {
        height: 23.25pt
      }

      table.sheet0 tr.row16 {
        height: 50.25pt
      }

      table.sheet0 tr.row17 {
        height: 23.25pt
      }

      table.sheet0 tr.row18 {
        height: 40.5pt
      }

      table.sheet0 tr.row19 {
        height: 23.25pt
      }

      table.sheet0 tr.row20 {
        height: 23.25pt
      }

      table.sheet0 tr.row21 {
        height: 23.25pt
      }

      table.sheet0 tr.row22 {
        height: 23.25pt
      }

      table.sheet0 tr.row23 {
        height: 23.25pt
      }

      table.sheet0 tr.row24 {
        height: 23.25pt
      }

      table.sheet0 tr.row25 {
        height: 23.25pt
      }

      table.sheet0 tr.row26 {
        height: 23.25pt
      }

      table.sheet0 tr.row27 {
        height: 23.25pt
      }

      table.sheet0 tr.row28 {
        height: 23.25pt
      }

      table.sheet0 tr.row29 {
        height: 23.25pt
      }

      table.sheet0 tr.row30 {
        height: 23.25pt
      }

      table.sheet0 tr.row31 {
        height: 23.25pt
      }

      table.sheet0 tr.row32 {
        height: 23.25pt
      }

      table.sheet0 tr.row33 {
        height: 23.25pt
      }

      table.sheet0 tr.row34 {
        height: 23.25pt
      }

      table.sheet0 tr.row35 {
        height: 23.25pt
      }

      table.sheet0 tr.row36 {
        height: 23.25pt
      }

      table.sheet0 tr.row37 {
        height: 23.25pt
      }

      table.sheet0 tr.row38 {
        height: 23.25pt
      }

      table.sheet0 tr.row39 {
        height: 23.25pt
      }

      table.sheet0 tr.row40 {
        height: 23.25pt
      }

      table.sheet0 tr.row41 {
        height: 23.25pt
      }

      table.sheet0 tr.row42 {
        height: 23.25pt
      }

      table.sheet0 tr.row43 {
        height: 23.25pt
      }

      table.sheet0 tr.row44 {
        height: 23.25pt
      }

      table.sheet0 tr.row45 {
        height: 23.25pt
      }

      table.sheet0 tr.row46 {
        height: 23.25pt
      }

      table.sheet0 tr.row47 {
        height: 23.25pt
      }

      table.sheet0 tr.row48 {
        height: 23.25pt
      }

      table.sheet0 tr.row49 {
        height: 23.25pt
      }

      table.sheet0 tr.row50 {
        height: 12pt
      }

      table.sheet0 tr.row51 {
        height: 12pt
      }

      table.sheet0 tr.row52 {
        height: 23.25pt
      }

      table.sheet0 tr.row53 {
        height: 23.25pt
      }

      table.sheet0 tr.row54 {
        height: 23.25pt
      }

      table.sheet0 tr.row55 {
        height: 46.5pt
      }

      table.sheet0 tr.row56 {
        height: 23.25pt
      }

      table.sheet0 tr.row57 {
        height: 23.25pt
      }

      table.sheet0 tr.row58 {
        height: 23.25pt
      }

      table.sheet0 tr.row59 {
        height: 23.25pt
      }

      table.sheet0 tr.row60 {
        height: 23.25pt
      }

      table.sheet0 tr.row61 {
        height: 23.25pt
      }

      table.sheet0 tr.row62 {
        height: 23.25pt
      }
    </style>
  </head>
  <body>
    <style>
      @page {
        margin-left: 0in;
        margin-right: 0in;
        margin-top: 0.39370078740157in;
        margin-bottom: 0in;
      }

      body {
        margin-left: 0in;
        margin-right: 0in;
        margin-top: 0.39370078740157in;
        margin-bottom: 0in;
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
      <tbody>
        <tr class="row0">
          <td class="column0">&nbsp;</td>
          <td class="column1 style70 s style44" colspan="9">PT. SARANA PACKAGING AGRAPANA</td>
          <td class="column10 style2 null"></td>
          <td class="column11 style3 null"></td>
        </tr>
        <tr class="row1">
          <td class="column0">&nbsp;</td>
          <td class="column1 style71 s style44" colspan="9">&nbsp;&nbsp;&nbsp;Order Produksi Internal</td>
          <td class="column10 style69 s">FR-PPIC-02</td>
          <td class="column11 style5 null"></td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1 style6 null"></td>
          <td class="column2 style6 null"></td>
          <td class="column3">&nbsp;</td>
          <td class="column4">&nbsp;</td>
          <td class="column5">&nbsp;</td>
          <td class="column6">&nbsp;</td>
          <td class="column7 style6 null"></td>
          <td class="column8 style7 null"></td>
          <td class="column9 style7 null"></td>
          <td class="column10 style7 null"></td>
          <td class="column11 style7 null"></td>
        </tr>
        <tr class="row3">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">Tipe Order</td>
          <td class="column3 style30 s" colspan="3" >{{ $opi2->tipeOrder }}</td>
          {{-- <td class="column4 style30 null"></td> --}}
          <td class="column5 style30 null"></td>
          <td class="column6 style30 s">Jumlah Order</td>
          <td class="column7 style49 ">{{ $opi2->pcsDt }}</td>
          <td class="column8 style30 "></td>
          <td class="column9 style52 null"></td>
          <td class="column10 style52 null"></td>
          <td class="column11 style53 null"></td>
        </tr>
        <tr class="row4">
          <td class="column0">&nbsp;</td>
          <td class="column1 style45 null"></td>
          <td class="column2 style45 null"></td>
          <td class="column3 style31 null"></td>
          <td class="column4 style31 null"></td>
          <td class="column5 style32 s">&nbsp;</td>
          <td class="column6 style32 null"></td>
          <td class="column7 style49 null"></td>
          <td class="column8 style54 null"></td>
          <td class="column9 style54 null"></td>
          <td class="column10 style54 null"></td>
          <td class="column11 style35 null"></td>
        </tr>
        <tr class="row5">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">Tanggal Order</td>
          <td class="column3 style33 n style34" colspan="2">{{ date('d F Y', strtotime($opi2->tglKontrak)) }}</td>
          <td class="column5 style35 s">&nbsp;</td>
          <td class="column6 style36 null"></td>
          <td class="column7 style49 s">Toleransi</td>
          <td class="column8 style54 s">+{{ $opi2->pctToleransiLebihKontrak }} / -{{ $opi2->pctToleransiKurangKontrak }} %</td>
          <td class="column9 style54 null"></td>
          <td class="column10 style54 null"></td>
          <td class="column11 style35 null"></td>
        </tr>
        <tr class="row6">
          <td class="column0">&nbsp;</td>
          <td class="column1 style46 s style44" colspan="2">NO. OPI</td>
          <td class="column3 style37 s style37" colspan="2">{{ $opi2->nama }}</td>
          <td class="column5 style38 s">&nbsp;&nbsp;</td>
          <td class="column6 style35 s">&nbsp;</td>
          <td class="column7 style50 s">Product Item</td>
          <td class="column8 style55 s style34" colspan="3">{{ $opi2->namaBarang }}</td>
          <td class="column11 style56 null"></td>
        </tr>
        <tr class="row7">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">No. SO</td>
          <td class="column3 style39 s style39" colspan="3">{{ $opi2->kode }}</td>
          <td class="column6 style35 s">&nbsp;</td>
          <td class="column7 style49 s">Kode Barang</td>
          <td class="column8 style39 s style39" colspan="3">{{ $opi2->kodeBarang }}</td>
          <td class="column11 style35 null"></td>
        </tr>
        <tr class="row8">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">No. MC</td>
          <td class="column3 style39 s style34" colspan="3">
            <?php
              if ($opi2->revisi == '') {
                echo $opi2->mcKode;
              } else if ($opi2->revisi == "R0") {
                echo $opi2->mcKode;
              }else {
                echo $opi2->mcKode."-".$opi2->revisi;
              }
            ?>
          </td>
          <td class="column6 style35 null"></td>
          <td class="column7 style49 s">Ukuran</td>
          <td class="column8 style57 s style57" colspan="3">{{ $opi2->panjang }}x{{ $opi2->lebar }}x{{ $opi2->tinggi }}</td>
          <td class="column11 style36 null"></td>
        </tr>
        <tr class="row9">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">PO Customer</td>
          <td class="column3 style40 s style34" colspan="4">{{ $opi2->poCustomer }}</td>
          <td class="column7 style49 s">Subs Produksi</td>
          <td class="column8 style58 s style34" colspan="3">{{ $opi2->subsKode }}</td>
          <td class="column11 style36 null"></td>
        </tr>
        <tr class="row10">
          <td class="column0">&nbsp;</td>
          <td class="column1 style47 s style48" colspan="2">Nama Customer</td>
          <td class="column3 style40 s style41" colspan="4">{{ $opi2->Cust }}</td>
          <td class="column7 style49 s">Flute</td>
          <td class="column8 style54 s">{{ $opi2->flute }}</td>
          <td class="column9 style30 null"></td>
          <td class="column10 style30 null"></td>
          <td class="column11 style35 null"></td>
        </tr>
        <tr class="row11">
          <td class="column0">&nbsp;</td>
          <td class="column1 style47 s style44" colspan="2">Alamat Kirim</td>
          <td class="column3 style42 s style34" colspan="4">{{ $opi2->alamatKirim }}</td>
          <td class="column7 style51 s">Warna</td>
          <td class="column8 style42 s style34" colspan="3">{{ $opi2->namacc }}</td>
          <td class="column11 style36 null"></td>
        </tr>
        <tr class="row12">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">Jadwal Kirim</td>
          <td class="column3 style33 n style34" colspan="4">{{ date('d F Y', strtotime($opi2->tglKirimDt)) }}</td>
          <td class="column7 style49 s">Out</td>
          <td class="column8 style54 null">{{ $opi2->outConv }}</td>
          <td class="column9 style59 null">RM :</td>
          @php

            $qty = ($opi2->jumlahOrder) / $opi2->outConv ; 
            // dd($qty);
            $outCorr = floor(2500/$opi2->lebarSheet);
            $cop = $qty / $outCorr;

            $rm = ($opi2->panjangSheet * $cop) / 1000;
          @endphp
          <td class="column10 style59 null">{{ floor($rm) }}</td>
          <td class="column11 style35 null"></td>
        </tr>
        <tr class="row13">
          <td class="column0">&nbsp;</td>
          <td class="column1 style43 s style44" colspan="2">Keterangan OPI</td>
          <td class="column3 style6 s">&nbsp;</td>
          <td class="column4 style8 null"></td>
          <td class="column5 style8 null"></td>
          <td class="column6 style8 null"></td>
          <td class="column7 style49 s">Berat Box</td>
          <td class="column8 style60 s">{{ number_format($opi2->gram,2,",",".") }} Kg</td>
          <td class="column9 style35 null"></td>
          <td class="column10 style35 null"></td>
          <td class="column11 style30 null"></td>
        </tr>
        <tr class="row14">
          <td class="column0">&nbsp;</td>
          <td class="column1 style9 s style18" colspan="7" rowspan="3">{{ $opi2->ketkontrak }}</td>
          <td class="column6 style12 null"></td>
          <td class="column7 style49 s">Isi Colly</td>
          <td class="column8 style30 s">{{ $opi2->koli }} pcs</td>
          <td class="column9 style30 null"></td>
          <td class="column10 style30 null"></td>
          <td class="column11 style30 null"></td>
        </tr>
        <tr class="row15">
          <td class="column0">&nbsp;</td>
          <td class="column6 style15 null"></td>
          <td class="column7 style49 s">Finishing</td>
          <td class="column8 style39 s style39" colspan="3">{{ $opi2->joint }}</td>
          <td class="column11 style61 null"></td>
        </tr>
        <tr class="row16">
          <td class="column0">&nbsp;</td>
          <td class="column6 style6 null"></td>
          <td class="column7 style51 s">Bentuk</td>
          <td class="column8 style62 s style62" colspan="3">{{ $opi2->tipeBox }}</td>
          <td class="column11 style72 null"></td>
        </tr>
        <tr class="row17">
          <td class="column0">&nbsp;</td>
          <td class="column1 style15 null"></td>
          <td class="column2 style15 null"></td>
          <td class="column3 style15 null"></td>
          <td class="column4 style15 null"></td>
          <td class="column5 style15 null"></td>
          <td class="column6 style15 null"></td>
          <td class="column7 style15 null"></td>
          <td class="column8 style15 null"></td>
          <td class="column9 style15 null"></td>
          <td class="column10 style15 null"></td>
          <td class="column11 style15 null"></td>
        </tr>
        <tr class="row18">
          <td class="column0">&nbsp;</td>
          <td class="column1 style27 s">Tgl</td>
          <td class="column2 style27 s">Jml Sheet</td>
          <td class="column3 style27 s">Hasil Flexo</td>
          <td class="column4 style27 s">Hasil DC</td>
          <td class="column5 style27 s">Hasil Slitter</td>
          <td class="column6 style27 s">Hasil Finishing</td>
          <td class="column7 style27 s">No. Bon</td>
          <td class="column8 style27 s">Serah Terima</td>
          <td class="column9 style27 s">Kirim</td>
          <td class="column10 style27 s">Keterangan</td>
          <td class="column11 style28 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        {{-- <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr> --}}
        {{-- <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row52">
          <td class="column0">&nbsp;</td>
          <td class="column1 style19 null style22" rowspan="2"></td>
          <td class="column2 style19 null style22" rowspan="2"></td>
          <td class="column3 style19 null style22" rowspan="2"></td>
          <td class="column4 style19 null style22" rowspan="2"></td>
          <td class="column5 style19 null style22" rowspan="2"></td>
          <td class="column6 style19 null style22" rowspan="2"></td>
          <td class="column7 style19 null style22" rowspan="2"></td>
          <td class="column8 style19 null style22" rowspan="2"></td>
          <td class="column9 style19 null style22" rowspan="2"></td>
          <td class="column10 style19 null style22" rowspan="2"></td>
          <td class="column11 style20 null"></td>
        </tr> --}}
        <tr class="row53">
          <td class="column0">&nbsp;</td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row55">
          <td class="column0">&nbsp;</td>
          <td class="column1 style65 s">TOTAL</td>
          <td class="column2 style24 null"></td>
          <td class="column3 style24 null"></td>
          <td class="column4 style24 null"></td>
          <td class="column5 style24 null"></td>
          <td class="column6 style24 null"></td>
          <td class="column7 style24 null"></td>
          <td class="column8 style24 null"></td>
          <td class="column9 style23 null"></td>
          <td class="column10 style23 null"></td>
          <td class="column11 style20 null"></td>
        </tr>
        <tr class="row56">
          <td class="column0">&nbsp;</td>
          <td class="column1 style25 null"></td>
          <td class="column2 style25 null"></td>
          <td class="column3 style20 null"></td>
          <td class="column4 style20 null"></td>
          <td class="column5 style20 null"></td>
          <td class="column6 style25 null"></td>
          <td class="column7 style25 null"></td>
          <td class="column8 style20 null"></td>
          <td class="column9 style20 null"></td>
          <td class="column10 style20 null"></td>
          <td class="column11 style25 null"></td>
        </tr>
        <tr class="row57">
          <td class="column0">&nbsp;</td>
          <td class="column1 style25 null"></td>
          <td class="column2 style25 null"></td>
          <td class="column3 style66 s style63" colspan="2">Mengetahui</td>
          <td class="column5 style67 null"></td>
          <td class="column6 style68 null"></td>
          <td class="column7 style64 null"></td>
          <td class="column8 style66 s style63" colspan="3">Mengetahui</td>
          <td class="column11 style25 null"></td>
        </tr>
        <tr class="row58">
          <td class="column0">&nbsp;</td>
          <td class="column1 style25 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column3 style68 null"></td>
          <td class="column4 style68 null"></td>
          <td class="column5 style68 null"></td>
          <td class="column6 style68 null"></td>
          <td class="column7 style64 null"></td>
          <td class="column8 style68 null"></td>
          <td class="column9 style68 null"></td>
          <td class="column10 style68 null"></td>
          <td class="column11 style25 null"></td>
        </tr>
        <tr class="row59">
          <td class="column0">&nbsp;</td>
          <td class="column1 style25 null"></td>
          <td class="column2 style25 null"></td>
          <td class="column3 style68 null"></td>
          <td class="column4 style68 null"></td>
          <td class="column5 style68 null"></td>
          <td class="column6 style68 null"></td>
          <td class="column7 style68 null"></td>
          <td class="column8 style68 null"></td>
          <td class="column9 style68 null"></td>
          <td class="column10 style68 null"></td>
          <td class="column11 style25 null"></td>
        </tr>
        <tr class="row60">
          <td class="column0">&nbsp;</td>
          <td class="column1 style25 null"></td>
          <td class="column2 style25 null"></td>
          <td class="column3 style68 null"></td>
          <td class="column4 style68 null"></td>
          <td class="column5 style68 null"></td>
          <td class="column6 style68 null"></td>
          <td class="column7 style68 null"></td>
          <td class="column8 style68 null"></td>
          <td class="column9 style68 null"></td>
          <td class="column10 style68 null"></td>
          <td class="column11 style25 null"></td>
        </tr>
        <tr class="row61">
          <td class="column0">&nbsp;</td>
          <td class="column1 style25 null"></td>
          <td class="column2 style25 null"></td>
          <td class="column3 style66 s style63" colspan="2">Kepala Regu</td>
          <td class="column5 style67 null"></td>
          <td class="column6 style68 null"></td>
          <td class="column7 style68 null"></td>
          <td class="column8 style66 s style63" colspan="3">Supervisor</td>
          <td class="column11 style25 null"></td>
        </tr>
        <tr class="row62">
          <td class="column0">&nbsp;</td>
          <td class="column1 style20 null"></td>
          <td class="column2 style20 null"></td>
          <td class="column3 style20 null"></td>
          <td class="column4 style20 null"></td>
          <td class="column5 style20 null"></td>
          <td class="column6 style20 null"></td>
          <td class="column7 style20 null"></td>
          <td class="column8 style20 null"></td>
          <td class="column9 style20 null"></td>
          <td class="column10 style26 f">{{ date("d/m/Y H:i:s") }}</td>
          <td class="column11 style20 null"></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>