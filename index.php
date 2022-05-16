<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
    <title>云服务推荐</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/bootstrap-table.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <style>
    hr {
        border: solid gray 0.5px;
    }

    .aliyun img,
    .tencent img,
    .ucloud img {
        width: 100px;
        margin-right: 20px;
    }

    .selectbar {
        background-color: rgb(238, 238, 238);
        margin-top: 10px;
        padding-top: 25px;
        padding-bottom: 10px;
    }

    .beforeselectbar {
        background-color: rgb(238, 238, 238);
        padding-top: 10px;
        padding-bottom: 10px;
    }

    #loading {
        height: 100px;
        font-size: 20px;
        line-height: 100px;
    }

    .searchbar a {
        font-size: 17px;
        color: black;
        line-height: 34px;
    }

    .searchbar a:hover {
        cursor: pointer;
        text-decoration: none;
    }

    .hidea {
        cursor: pointer;
        text-decoration: none;
        color: black;
        font-size: 15px;
    }

    .rankthree {
        border: 1px solid lightgray;
        padding: 5px;
        color: gray;

    }

    .rankthree span {
        margin-left: 10px;
    }

    .rankthree ul,
    li {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rankthree ul {
        margin-left: 10px;
    }

    .dot {
        width: 20px;
    }

    .rank47 {
        margin-top: 20px;
        margin-right: 20px;
        font-size: 17px;
    }

    .rank47 img {
        height: 70px;
    }
    </style>
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/defaults-zh_CN.min.js"></script>
    <script>
        $.extend({
            csv: function (url, f) {
                $.get(url, function (record) {
                    //按回车拆分  
                    record = record.split("\r\n");
                    //第一行标题  
                    var title = record[0].split(",");
                    //删除第一行  
                    record.shift();
                    var data = [];
                    for (var i = 0; i < record.length-1; i++) {//最后一行为空行也会被读取 -1
                        var t = record[i].split(",");
                        for (var y = 0; y < t.length; y++) {
                            if (!data[i]) data[i] = {};
                            data[i][title[y]] = t[y];
                        }
                    }
                    f.call(this, data);
                    data = null;
                });
            }
        });
    var array = [];
    $.csv("datas/bench_results.csv", function (data) {
    //each循环 使用$.each方法遍历返回的数据date
    array = data;
    $(function () {
        $('#table').bootstrapTable({
            //请求方法
            method: 'get',
            //是否显示行间隔色
            striped: true,
            //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）     
            cache: false,
            //是否显示分页（*）  
            pagination: true,
            //是否启用排序  
            sortable: true,
            //排序方式 
            sortOrder: "asc",
            //初始化加载第一页，默认第一页
            //我设置了这一项，但是貌似没起作用，而且我这默认是0,- -
            //pageNumber:1,   
            //每页的记录行数（*）   
            pageSize: 25,
            //可供选择的每页的行数（*）    
            pageList: [10, 25, 50, 100],
            //这个接口需要处理bootstrap table传递的固定参数,并返回特定格式的json数据  
            data: array,
            //默认值为 'limit',传给服务端的参数为：limit, offset, search, sort, order Else
            //queryParamsType:'',   
            ////查询参数,每次调用是会带上这个参数，可自定义                         
            /*                queryParams: queryParams : function(params) {
                                var subcompany = $('#subcompany option:selected').val();
                                var name = $('#name').val();
                                return {
                                      pageNumber: params.offset+1,
                                      pageSize: params.limit,
                                      companyId:subcompany,
                                      name:name
                                    };
                            },*/
            //分页方式：client客户端分页，server服务端分页（*）
            sidePagination: "client",
            //是否显示搜索
            search: true,
            //Enable the strict search.    
            strictSearch: true,
            //Indicate which field is an identity field.
            idField: "id",
            columns: [
                { title: 'id', field: 'id', visible: false, align: 'center', valign: 'middle' },
                { title: '云服务厂商', field: 'vendor', align: 'center', valign: 'middle' },
                { title: '实例', field: 'instance', align: 'center', valign: 'middle' },
                { title: 'CPU', field: 'CPU', align: 'center', valign: 'middle', sortable: true },
                { title: '内存', field: 'memory', align: 'center', valign: 'middle', sortable: true },
                { title: 'CPU性能', field: 'totalcpu', align: 'center', valign: 'middle', sortable: true },
                { title: 'IO性能', field: 'totalio', align: 'center', valign: 'middle', sortable: true },
                { title: '内存性能', field: 'totalmem', align: 'center', valign: 'middle', sortable: true },
                { title: '网络性能', field: 'totalnet', align: 'center', valign: 'middle', sortable: true },
                { title: '总分', field: 'total', align: 'center', valign: 'middle', sortable: true },
                { title: '价格', field: 'price', align: 'center', valign: 'middle', sortable: true }],
            pagination: true,
            toolbar: "#toolbar",
            onEditableSave: function (field, row, oldValue, $el) {
                $.ajax({
                    type: "post",
                    url: "/Editable/Edit",
                    data: { strJson: JSON.stringify(row) },
                    success: function (data, status) {
                        if (status == "success") {
                            alert("编辑成功");
                        }
                    },
                    error: function () {
                        alert("Error");
                    },
                    complete: function () {

                    }

                });
            },
            showHeader: true,
            showRefresh: true,
            showFooter: false,
            showToggle: true,
            showColumns: true,
            iconsPrefix: 'glyphicon',
            icons: {
                paginationSwitchDown: 'glyphicon-collapse-down icon-chevron-down',
                paginationSwitchUp: 'glyphicon-collapse-up icon-chevron-up',
                refresh: 'glyphicon-refresh icon-refresh',
                toggle: 'glyphicon-list-alt icon-list-alt',
                columns: 'glyphicon-th icon-th',
                detailOpen: 'glyphicon-plus icon-plus',
                detailClose: 'glyphicon-minus icon-minus'
            }
        });
    });
    });
</script>

<body>
    <!-- 导航 -->
    <div class="navbar navbar-fixed-top">
        <div class="container">
            <!-- Collapsed navigation -->
            <div class="navbar-header">
                <!-- Expander button -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Main title -->
                <a class="navbar-brand" href="meter.html">云服务评分</a>
            </div>
            <!-- Expanded navigation -->
            <div class="navbar-collapse collapse">
                <!-- Main navigation -->
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="documents.html">文档</a>
                    </li>
                    <li>
                        <a href="bench.html">云服务评测</a>
                    </li>
                    <li>
                        <a href="ml.html">机器学习推荐</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">About <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Contact</a>
                            </li>
                            <li>
                                <a href="#">Contributing</a>
                            </li>
                            <li>
                                <a href="#">Team</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Search, Navigation and Repo links -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#">
                            <i class="fa fa-search"></i> Search
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-github"></i>
                            GitHub
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="jumbotron">
            <div class="container">
                <h1>云服务推荐</h1>
                <p>针对您的需求推荐最适合的云服务器。</p>
                <p><a class="btn btn-primary btn-lg" role="button">
                        学习更多</a>
                </p>
            </div>
        </div>
    </div>
    <div class="container searchbar">
        <div class="row">
            <div class="col-sm-8">
                <div class="input-group">
                    <input type="text" class="form-control">
                    <div class="input-group-btn">
                        <button class="btn btn-primary pull-right">搜索</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <button class="btn btn-primary pull-right" onclick="$('.selectbar').toggle();">筛选过滤 <i
                        class="fa fa-filter"></i></button>
            </div>
        </div>
    </div>
    <div class="container selectbar">
        <form class="form-horizontal" role="form" action="index.php" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">场景</label>
                <div class="col-sm-7">
                    <select class="selectpicker" name="scenario[]" data-actions-box="true" multiple style="width: 100%;">
                        <option value="1" selected>均衡性能</option>
                        <option value="2" selected>高网络收发包应用</option>
                        <option value="3" selected>高性能计算</option>
                        <option value="4" selected>高性能端游</option>
                        <option value="5" selected>手游、页游</option>
                        <option value="6" selected>视频转发</option>
                        <option value="7" selected>直播弹幕</option>
                        <option value="8" selected>关系型数据库</option>
                        <option value="9" selected>分布式缓存</option>
                        <option value="10" selected>NoSQL数据库</option>
                        <option value="11" selected>Elastic search</option>
                        <option value="12" selected>Hadoop</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">云服务厂商</label>
                <div class="col-sm-7">
                    <select class="selectpicker" name="provider[]" data-actions-box="true" multiple style="width: 100%;">
                        <option value="1" selected>阿里云</option>
                        <option value="2" selected>华为云</option>
                        <option value="3" selected>腾讯云</option>
                        <option value="4" selected>uCloud</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">云服务类型</label>
                <div class="col-sm-7">
                    <select class="selectpicker" name="kind[]" data-actions-box="true" multiple style="width: 100%;">
                        <option value="1" selected>通用型/标准型</option>
                        <option value="2" selected>计算型</option>
                        <option value="3" selected>内存型</option>
                        <option value="4" selected>高主频型</option>
                    </select>
                </div>
            </div>
            <script>
            $('.selectpicker').selectpicker({
                width: "100%"
            });
            </script>
            <div class="form-group custom-control-inline">
                <label class="col-sm-2 control-label">vCPU数量</label>
                <div class="col-sm-3">
                    <input class="form-control" name="cpumin" type="number" value="0" min="0" max="12">
                </div>
                <div class="col-sm-1 text-center" style="line-height: 34px;">至</div>
                <div class="col-sm-3">
                    <input class="form-control" name="cpumax" type="number" value="12" min="0" max="12">
                </div>
            </div>
            <div class="form-group custom-control-inline">
                <label class="col-sm-2 control-label">内存大小(GB)</label>
                <div class="col-sm-3">
                    <input class="form-control" name="memmin" type="number" value="0" min="0" max="96">
                </div>
                <div class="col-sm-1 text-center" style="line-height: 34px;">至</div>
                <div class="col-sm-3">
                    <input class="form-control" name="memmax" type="number" value="96" min="0" max="96">
                </div>
            </div>
            <div class="form-group custom-control-inline">
                <label class="col-sm-2 control-label">评分指标权重</label>
                <div class="col-sm-1 text-center" style="line-height: 34px;">CPU</div>
                <div class="col-sm-2">
                    <input class="form-control" name="cpuscore" type="text" value="0.25">
                </div>
                <div class="col-sm-1 text-center" style="line-height: 34px;">内存</div>
                <div class="col-sm-2">
                    <input class="form-control" name="memscore" type="text" value="0.25">
                </div>
            </div>
            <div class="form-group custom-control-inline">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-1 text-center" style="line-height: 34px;">磁盘</div>
                <div class="col-sm-2">
                    <input class="form-control" name="diskscore" type="text" value="0.25">
                </div>
                <div class="col-sm-1 text-center" style="line-height: 34px;">网络</div>
                <div class="col-sm-2">
                    <input class="form-control" name="netscore" type="text" value="0.25">
                </div>
                <div class="col-sm-2 text-center" style="line-height: 34px;">注：四个权重和为1</div>
            </div>
            <input class="btn btn-primary pull-right" type="submit"></input>
        </form>
    </div>
    <script>
    $('.selectbar').hide();
    </script>
    

    <div class="container main">
        <div id="requiredVMs">
            <h3 style="margin-bottom: 30px;">筛选实例</h3>
            <table id="table">
            </table>
            <?php
            $chj = array("g6,hfg6,n,s6,s5","g6,n,s6,s5,c6,c3,r6,m5,m6","g6,n,s6,s5,hfc6","g6,n,s6,s5,c6,c3,hfg6,hfc6","c6,c3,hfc6","c6,c3,hfc6","g6,n,s6,s5,c6,c3,hfg6,hfc6",
            "g6,n,s6,s5,r6,m5,m6","g6,n,s6,s5,r6,m5,m6,hfg6,hfr6","g6,n,s6,s5,r6,m5,m6","g6,n,s6,s5,r6,m5,m6","g6,n,s6,s5,r6,m5,m6");
            $kinds = array("g6,n,s6,s5", "c6,c3", "r6,m5,m6", "hfg6,hfc6,hfr6");
            $providers = array("aliyun", "huawei", "tencent", "ucloud");
            $provider = $_POST["provider"];
            $kind = $_POST["kind"];
            $scenario = $_POST["scenario"];
            $cpumin = $_POST["cpumin"];
            $cpumax = $_POST["cpumax"];
            $memmin = $_POST["memmin"];
            $memmax = $_POST["memmax"];
            $cpuscore = $_POST["cpuscore"];
            $memscore = $_POST["memscore"];
            $diskscore = $_POST["diskscore"];
            $netscore = $_POST["netscore"];
            if (count($provider) == 0 or count($kind) == 0 or count($scenario) == 0) {
                echo "没有符合条件的实例！";
            } 
            else {
                $p = "";
                foreach($provider as $value) {
                    if ($p != "") {
                        $p = $p . " or ";
                    }
                    $p = $p . "vendor = '" .$providers[$value-1]."'";
                }
                foreach($scenario as $value) {
                    $chj[$value-1];
                }
                "select * from scores where CPU >= ".$cpumin." and CPU <= ".$cpumax." and memory >= ".$memmin." and memory <= ".$memmax." and (".$p.")";
            }
            ?>
        </div>
        <div class="other" style="margin-top: 50px;">
            <h3 style="margin-bottom: 30px;">优惠活动</h3>
            <a href="https://www.aliyun.com/activity?spm=5176.8789780.h2v3icoap.1.585e55caVH9ykv#/promotionArea" target="_blank"><img src="img/ali.png" style="width: 15%;"></a>
            <a href="https://activity.huaweicloud.com/promotion/" target="_blank"><img src="img/hua.png" style="width: 15%; margin-left: 8%;"></a>
            <a href="https://cloud.tencent.com/act" target="_blank"><img src="img/ten.png" style="width: 15%; margin-left: 8%;"></a>
            <a href="https://www.ucloud.cn/site/active/1111.html" target="_blank"><img src="img/ucl.png" style="width: 15%; margin-left: 8%;"></a>
        </div>
        <div class="other" style="margin-top: 50px;">
            <h3 style="margin-bottom: 30px;">学生优惠</h3>
            <a href="https://developer.huaweicloud.com/campus" target="_blank"><img src="img/hua.png" style="width: 15%; margin-left: 8%;"></a>
            <a href="https://cloud.tencent.com/act/campus" target="_blank"><img src="img/ten.png" style="width: 15%; margin-left: 8%;"></a>
        </div>
        <div class="other" style="margin-top: 50px;">
            <h3 style="margin-bottom: 30px;">免费试用</h3>
            <a href="https://www.aliyun.com/daily-act/ecs/free?spm=5176.8789780.1092586.8.783555caRtiIV5" target="_blank"><img src="img/ali.png" style="width: 15%;"></a>
            <a href="https://activity.huaweicloud.com/free_test/index.html?ggw_hd" target="_blank"><img src="img/hua.png" style="width: 15%; margin-left: 8%;"></a>
            <a href="https://cloud.tencent.com/document/product/1137/46356" target="_blank"><img src="img/ten.png" style="width: 15%; margin-left: 8%;"></a>
        </div>
        <div class="other" style="margin-top: 50px;">
            <h3 style="margin-bottom: 30px;">详细实例介绍</h3>
            <a href="https://help.aliyun.com/document_detail/25378.html?spm=a2c4g.11186623.6.590.712678b7RG27SN" target="_blank"><img src="img/ali.png" style="width: 15%;"></a>
            <a href="https://support.huaweicloud.com/productdesc-ecs/zh-cn_topic_0159822360.html" target="_blank"><img src="img/hua.png" style="width: 15%; margin-left: 8%;"></a>
            <a href="https://cloud.tencent.com/document/product/213/11518" target="_blank"><img src="img/ten.png" style="width: 15%; margin-left: 8%;"></a>
            <a href="https://docs.ucloud.cn/uhost/introduction/uhost/type" target="_blank"><img src="img/ucl.png" style="width: 15%; margin-left: 8%;"></a>
        </div>
    </div>

    <!--modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">机器学习推荐</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="javascript:void(0)">
                        <span style="margin-left: 20px">任务程序：</span>
                        <input id="file" type="file" class="form-control"
                            style="width: 220px; display: inline-block; margin-top: 10px; margin-bottom: 10px">
                        <br />
                        <span style="margin-left: 20px; margin-right: 13px">执行命令：</span>
                        <input id="command" type="text" class="form-control"
                            style="width: 220px; display: inline-block; margin-top: 10px; margin-bottom: 10px">
                        <br />
                        <span style="margin-left: 20px; margin-right: 13px">实例规格：</span>
                        <select id="kind" class="selectpicker" data-size="6" multiple data-actions-box="true">
                            <option value="ecs.g5.large">ecs.g5.large</option>
                            <option value="ecs.g5.xlarge">ecs.g5.xlarge</option>
                            <option value="ecs.g5.2xlarge">ecs.g5.2xlarge</option>
                            <option value="ecs.g5.3xlarge">ecs.g5.3xlarge</option>
                            <option value="ecs.c5.large">ecs.c5.large</option>
                            <option value="ecs.c5.xlarge">ecs.c5.xlarge</option>
                            <option value="ecs.c5.2xlarge">ecs.c5.2xlarge</option>
                            <option value="ecs.c5.3xlarge">ecs.c5.3xlarge</option>
                            <option value="ecs.r5.large">ecs.r5.large</option>
                            <option value="ecs.r5.xlarge">ecs.r5.xlarge</option>
                            <option value="ecs.r5.2xlarge">ecs.r5.2xlarge</option>
                            <option value="ecs.r5.3xlarge">ecs.r5.3xlarge</option>
                            <option value="ecs.d1ne.2xlarge">ecs.d1ne.2xlarge</option>
                            <option value="ecs.i2g.2xlarge">ecs.i2g.2xlarge</option>
                            <option value="ecs.i2.xlarge">ecs.i2.xlarge</option>
                            <option value="ecs.i2.2xlarge">ecs.i2.2xlarge</option>
                            <option value="ecs.hfg5.large">ecs.hfg5.large</option>
                            <option value="ecs.hfg5.xlarge">ecs.hfg5.xlarge</option>
                            <option value="ecs.hfg5.2xlarge">ecs.hfg5.2xlarge</option>
                            <option value="ecs.hfg5.3xlarge">ecs.hfg5.3xlarge</option>
                            <option value="ecs.hfc5.large">ecs.hfc5.large</option>
                            <option value="ecs.hfc5.xlarge">ecs.hfc5.xlarge</option>
                            <option value="ecs.hfc5.2xlarge">ecs.hfc5.2xlarge</option>
                            <option value="ecs.hfc5.3xlarge">ecs.hfc5.3xlarge</option>
                        </select>
                        <br />
                        <span style="margin-left: 20px; margin-right: 13px">性能成本目标：</span>
                        <select id="supplier" class="selectpicker">
                            <option value="1">性能最好</option>
                            <option value="2">成本最低</option>
                            <option value="3">其他</option>
                        </select>
                        <br />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="addRecord"
                        onclick="alert('请在我的评测中查看结果'); ">提交</button>
                </div>
            </div>
        </div>
    </div>

    <footer style="margin-bottom: 5px;">
        <hr>
        <center>&#169; Unias Team, SEI, PKU</center>
        <center>Documentation built with <a href="http://www.mkdocs.org/">MkDocs</a>.</center>
    </footer>
</body>

</html>