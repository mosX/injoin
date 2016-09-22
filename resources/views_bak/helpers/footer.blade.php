 <style>
    #footer{
        background: black url('./images/footer.jpg') no-repeat center center;
        background-size: cover;
        height:250px;
        width:100%;
    }

    #footer .left,#footer .right{
        display:inline-block;
        vertical-align: top;
    }
    #footer .left{
        width:400px;
        height:100%;
    }
    #footer .left div{
        color:#dddddd;
    }
    #footer .right{
        padding-top:50px;
        width:755px;
        height:100%;
    }
    #footer .right ul{
        margin-left:20px;
        padding:10px 0px;
        min-width:220px;
        display: inline-block;
        vertical-align: top;
        border-right:1px solid #ddd;
    }
    #footer .right ul a{
        color: white;
    }
    #footer .right ul div{
        color:#13c6ec;
        font-size:20px;
    }
    #footer .left .logo{
        margin-top:50px;
        display:block;
        background: url('/images/logo.png');
        width:186px;
        height:48px;
    }
    .copyright{
        text-align: center;
        height:30px;
        background: #dddddd;
    }
</style>
<div id='footer'>
   <div class='container'>
       <div class='left'>
           <a href='' class='logo'></a>
           <div>тел: 0636009642</div>
           <div>E-mail: s.sivinyuk@gmail.com</div>
       </div>
       <div class='right'>
           <ul>
               <div>Раздел1</div>
               <li><a href=''>Пункт 1</a></li>
               <li><a href=''>Пункт 2</a></li>
               <li><a href=''>Пункт 3</a></li>
               <li><a href=''>Пункт 4</a></li>
           </ul>

           <ul>
               <div>Раздел2</div>
               <li><a href=''>Пункт 1</a></li>
               <li><a href=''>Пункт 2</a></li>
               <li><a href=''>Пункт 3</a></li>
               <li><a href=''>Пункт 4</a></li>
           </ul>
       </div>
   </div>
</div>
<div class='copyright'><div class='inner'>Copyright by company 2016</div></div>