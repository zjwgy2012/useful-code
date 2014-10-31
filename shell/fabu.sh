#!/bin/sh
#--------------------CopyRight------------------------------------
# Name:发布脚本
# Author:zhangjingwei
# Time:2014-03-18
# Desc:首次发布时采用init参数,以后每次发布的时候根据修改的文件采用具体选项进行增量发布
# Usage:sh fabu.sh [init|static|web|]
# Notes:先发布一台线上机器,确定无误再全部发布
#-----------------------------------------------------------------

# 全部线上机器
#ips=""

#cd ..
#init全量
if [ x$1 = "xinit" ]; then
        for ip in $ips
        do
           echo $ip
           rsync -avz ./web/* --exclude ".git"  username@$ip::kan/web/
           rsync -avz ./fe/static --exclude ".git" username@$ip::kan/web/views
           rsync -avz ./fe/template --exclude ".git" username@$ip::kan/web/views
        done
fi
#前端静态资源和模板
if [ x$1 = "xstatic" ] || [ x$1 = "xall" ]; then
        for ip in $ips
        do  
           rsync -avz ./fe/static --exclude ".git" username@$ip::kan/web/views
           rsync -avz ./fe/template --exclude ".git" username@$ip::kan/web/views
        done
fi
#web页面展示代码
if [ x$1 = "xweb" ] || [ x$1 = "xall" ]; then
        for ip in $ips
        do
           rsync -avz ./web/* --exclude ".git" --exclude "cache" username@$ip::kan/web/ 
           rsync -avz ./web/web_online.xml username@$ip::kan/web/web.xml
       done
fi
