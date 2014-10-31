#!/bin/sh
#--------------------CopyRight------------------------------------
# Name:发布准备脚本
# Author:zhangjingwei
# Time:2014-03-18
# Desc:在执行发布脚本之前执行该脚本进行发布之前的准备操作
# Usage:sh fabu_prepare.sh [dev|test|fabu]
# Notes:确保web/views/template/cms下碎片存在，否则不要执行改脚本
#-----------------------------------------------------------------

#-------------------参数合法性判断--------------------------------
if [ -z $1 ]
then
    echo "参数不能为空,请输入参数[dev|test|fabu]"
    exit
elif [ x$1 != "xdev" ] && [ x$1 != "xtest" ] && [ x$1 != "xfabu" ]
then
    echo "请输入合法参数[dev|test|fabu]"
    exit
fi
#-------------------切换目录到kan---------------------------------
cd ../
#-------------------增加文件权限----------------------------------
chmod -R 777 admin/cache/smarty_*
chmod -R 777 logs
chmod -R 777 web/cache/twig_compile
chmod -R 777 web/views/template/cms
#-------------------增加配置文件的软链接--------------------------
cd config
ln -s db_config_$1.php db_config.php
cd ../web/player/code/WEB-INF
ln -s web_$1.xml web.xml
cd ../../../../
#-------------------判断cms下碎片是否存在-------------------------
if [ `ls web/views/template/cms|wc -l` -lt 45 ]
then
    echo "cms碎片不完整，请补充完整"
    exit
fi
#-------------------执行静态化文件本地生成脚本--------------------
cd data
sh make_page_to_local.sh
cd ../web/views
html=`ls -l html | awk '$5==0&&/html$/{print $9}'`
if [ x"$html" != "x" ]
then
    echo "下面静态文件为空,请重新生成再执行发布脚本"
    echo "$html"
    exit
else 
    echo "所有准备工作都已经做好,可以执行发布脚本"
    exit
fi
