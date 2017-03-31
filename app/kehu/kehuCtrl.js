define(function (require) {
    var app = require('../../app');
    require('jquery');
    require('bootstrap');
    require('datepicker');
    require('moment_timezone');

    require('angular-datepicker');
    app.useModule('daterangepicker');
    require('angular-md5');
    app.useModule('angular-md5');
    app.controller('kehuCtrl', function ($scope, $http,$state,userList,ngDialog,md5) {
        $scope.date = {
            startDate: moment().subtract(1, 'days'),
            endDate:moment().subtract(1, 'days')
        };
        //省份
        var provinceArr = ["省份","北京市","天津市","上海市","重庆市","河北省","河南省","云南省","辽宁省","黑龙江省","湖南省","安徽省","山东省","新疆维吾尔自治区","江苏省","浙江省","江西省","湖北省","广西壮族","甘肃省","山西省","内蒙古自治区","陕西省","吉林省","福建省","贵州省","广东省","青海省","西藏","四川省","宁夏回族","海南省","台湾省","香港特别行政区","澳门特别行政区"];
//城市
        var cityArr = [
            ['市县'],
            ['东城区', '西城区','崇文区','宣武区','朝阳区','丰台区','石景山区', '海淀区','门头沟区', '房山区','通州区','顺义区','昌平区','大兴 区','怀柔区','平谷区','密云县','延庆县'],
            ['和平区','河东区', '河西区', '南开区', '河北区', '红桥区', '塘沽区', '汉沽区', '大港区', '东丽区', '西青区', '津南区', '北辰区', '武清区', '宝坻区', '宁河县', '静海县', '蓟县'],
            ['黄浦区','卢湾区', '徐汇区','长宁区','静安区','普陀区','闸北区','虹口区', '杨浦区', '闵行区', '宝山区', '嘉定区', '浦东新区', '金山区', '松江区', '青浦区', '南汇区', '奉贤区', '崇明县'],
            ['万州区','涪陵区','渝中区','大渡口区','江北区','沙坪坝区','九龙坡区','南岸区','北碚区','万盛区','双桥区','渝北区','巴南区','黔江区','长寿区','江津区','合川区','永川区','南川区','綦江县','潼南县','铜梁县','大足县','荣昌县','璧山县','梁平县','城口县','丰都县','垫江县','武隆县','忠县','开县','云阳县','奉节县','巫山县','巫溪县','石柱土家族自治县','秀山土家族苗族自治县','酉阳土家族苗族自治县','彭水苗族土家族自治县'],
            ['石家庄市', '唐山市', '秦皇岛市', '邯郸市', '邢台市', '保定市', '张家口市', '承德市', '沧州市', '廊坊市', '衡水市'],
            ['郑州市','开封市','洛阳市', '平顶山市', '安阳市', '鹤壁市', '新乡市', '焦作市', '济源市', '濮阳市', '许昌市', '漯河市', '三门峡市', '南阳市', '商丘市', '信阳市', '周口市', '驻马店市'],
            ['昆明市',' 曲靖市','玉溪市','保山市','昭通市','丽江市','思茅市','临沧市','楚雄彝族自治州','红河哈尼族彝族自治州','文山壮族苗族自治州','西双版纳傣族自治州','大理白族自治州','德宏傣族景颇族自治州','怒江傈僳族自治州','迪庆藏族自治州'],
            ['沈阳市' ,'大连市' ,'鞍山市' ,'抚顺市' ,'本溪市' ,'丹东市' ,'锦州市' ,'营口市' ,'阜新市' ,'辽阳市' ,'盘锦市' ,'铁岭市' ,'朝阳市' ,'葫芦岛市'],
            ['哈尔滨市','齐齐哈尔市','鸡西市','鹤岗市','双鸭山市', '大庆市', '伊春市', '佳木斯市', '七台河市', '牡丹江市', '黑河市', '绥化市', '大兴安岭地区'],
            ['长沙市', '株洲市','湘潭市', '衡阳市', '邵阳市', '岳阳市', '常德市', '张家界市', '益阳市', '郴州市', '永州市', '怀化市', '娄底市', '湘西土家族苗族自治州'],
            ['合肥市', '芜湖市', '蚌埠市', '淮南市', '马鞍山市', '淮北市', '铜陵市', '安庆市', '黄山市', '滁州市','阜阳市','宿州市', '巢湖市', '六安市', '亳州市', '池州', '宣城市'],
            ['济南市','青岛市','淄博市','枣庄市','东营市','烟台市','潍坊市','济宁市','泰安市','威海市','日照市','莱芜市','临沂市','德州市','聊城市','滨州市','菏泽市'],
            ['乌鲁木齐市', '克拉玛依市', '吐鲁番地区', '哈密地区', '昌吉回族自治州 ', '博尔塔拉蒙古自治州 ', '巴音郭楞蒙古自治州 ', '阿克苏地区', '克孜勒苏柯尔克孜自治州 ', '喀什地区', '和田地区', '伊犁哈萨克自治州', '塔城地区', '阿勒泰地区', '石河子市', '阿拉尔市', '图木舒克市', '五家渠市' ],
            ['南京市', '无锡市', '徐州市', '常州市', '苏州市', '南通市', '连云港市', '淮安市', '盐城市', '扬州市', '镇江市', '泰州市', '宿迁市' ],
            ['杭州市', '宁波市', '温州市', '嘉兴市', '湖州市', '绍兴市', '金华市', '衢州市', '舟山市', '台州市', '丽水市'],
            ['南昌市','景德镇市','萍乡市','九江市','新余市','鹰潭市','赣州市','吉安市','宜春市','抚州市','上饶市'],
            ['武汉市','黄石市','十堰市', '宜昌市', '襄樊市', '鄂州市', '荆门市', '孝感市', '荆州市', '黄冈市', '咸宁市', '随州市', '恩施土家族苗族自治州','仙桃市', '潜江市', '天门市', '神农架林区'],
            ['南宁市','柳州市','桂林市','梧州市','北海市','防城港市','钦州市','贵港市','玉林市','百色市','贺州市','河池市','来宾市','崇左市'],
            ['兰州市','嘉峪关市', '金昌市', '白银市', '天水市', '武威市', '张掖市', '平凉市', '酒泉市', '庆阳市', '定西市', '陇南市', '临夏回族自治州', '甘南藏族自治州'],
            ['太原市','大同市', '阳泉市', '长治市', '晋城市', '朔州市', '晋中市', '运城市', '忻州市', '临汾市', '吕梁市' ],
            ['呼和浩特市', '包头市', '乌海市', '赤峰市', '通辽市', '鄂尔多斯市', '呼伦贝尔市', '巴彦淖尔市', '乌兰察布市', '兴安盟', '锡林郭勒盟', '阿拉善盟' ],
            ['西安市','铜川市','宝鸡市', '咸阳市', '渭南市', '延安市', '汉中市', '榆林市', '安康市', '商洛市' ],
            ['长春市', '吉林市', '四平市', '辽源市', '通化市', '白山市', '松原市', '白城市', '延边朝鲜族自治州'],
            ['福州市', '厦门市', '莆田市', '三明市', '泉州市', '漳州市', '南平市', '龙岩市', '宁德市' ],
            ['贵阳市','六盘水市', '遵义市', '安顺市', '铜仁地区', '黔西南布依族苗族自治州', '毕节地区', '黔东南苗族侗族自治州', '黔南布依族苗族自治州'],
            ['广州市','韶关市','深圳市','珠海市','汕头市','佛山市','江门市','湛江市','茂名市','肇庆市','惠州市','梅州市','汕尾市','河源市','阳江市','清远市','东莞市','中山市','潮州市','揭阳市','云浮市'],
            ['西宁市' ,'海东地区', '海北藏族自治州', '黄南藏族自治州', '海南藏族自治州', '果洛藏族自治州', '玉树藏族自治州', '海西蒙古族藏族自治州'],
            ['拉萨市','昌都地区', '山南地区', '日喀则地市', '那曲地区', '阿里地区', '林芝地区' ],
            ['成都市','自贡市', '攀枝花市', '泸州市', '德阳市', '绵阳市', '广元市', '遂宁市', '内江市', '乐山市', '南充市', '眉山市', '宜宾市', '广安市', '达州市', '雅安市', '巴中市', '资阳市', '阿坝藏族羌族自治州', '甘孜藏族自治州', '凉山彝族自治州'],
            ['银川市','石嘴山市','吴忠市','固原市','中卫市'],
            ['海口市','三亚市','五指山市', '琼海市', '儋州市', '文昌市', '万宁市', '东方市', '定安县', '屯昌县', '澄迈县', '临高县', '白沙黎族自治县', '昌江黎族自治县', '乐东黎族自治县', '陵水黎族自治县', '保亭黎族苗族自治县', '琼中黎族苗族自治县' ],
            ['台北市', '高雄市', '基隆市', '台中市', '台南市', '新竹市', '嘉义市'],
            ['中西区', '湾仔区', '东区', '南区', '油尖旺区', '深水埗区', '九龙城区', '黄大仙区', '观塘区', '荃湾区', '葵青区', '沙田区', '西贡区', '大埔区', '北区', '元朗区', '屯门区', '离岛区' ],
            ['澳门']
        ];
        $scope.provinceArr = provinceArr ; //省份数据
        $scope.cityArr = cityArr;    //城市数据
        $scope.getCityArr = $scope.cityArr[0]; //默认为省份
        $scope.getCityIndexArr = ['0','0'] ; //这个是索引数组，根据切换得出切换的索引就可以得到省份及城市
        $scope.citySelected = [provinceArr[$scope.getCityIndexArr[0]],cityArr[$scope.getCityIndexArr[0]][$scope.getCityIndexArr[1]] ]
        //改变省份触发的事件 [根据索引更改城市数据]
        $scope.provinceChange = function(index)
        {
            $scope.getCityArr = $scope.cityArr[index] ; //根据索引写入城市数据
            $scope.getCityIndexArr[1] = '0' ; //清除残留的数据
            $scope.getCityIndexArr[0] = index ;
            //输出查看数据
            // console.log($scope.getCityIndexArr,provinceArr[$scope.getCityIndexArr[0]],cityArr[$scope.getCityIndexArr[0]][$scope.getCityIndexArr[1]]);
            $scope.citySelected = [provinceArr[$scope.getCityIndexArr[0]],cityArr[$scope.getCityIndexArr[0]][$scope.getCityIndexArr[1]] ]
        }
        //改变城市触发的事件
        $scope.cityChange = function(index)
        {
            $scope.getCityIndexArr[1] = index ;
            //输出查看数据
            $scope.citySelected = [provinceArr[$scope.getCityIndexArr[0]],cityArr[$scope.getCityIndexArr[0]][$scope.getCityIndexArr[1]]]
            // console.log($scope.getCityIndexArr,provinceArr[$scope.getCityIndexArr[0]],cityArr[$scope.getCityIndexArr[0]][$scope.getCityIndexArr[1]]);
            // console.log(provinceArr[$scope.getCityIndexArr[0]],cityArr[$scope.getCityIndexArr[0]][$scope.getCityIndexArr[1]])
        }
        $scope.opts = {
            locale: {
                applyClass: 'btn-green',
                applyLabel: "确定",
                fromLabel: "Od",
                format: "YYYY-MM-DD",
                toLabel: "Do",
                cancelLabel: '取消',
                customRangeLabel: '自定义日期',
                autoApply: true,
                firstDay: 1,
            },
            ranges: {
                '过去7天': [moment().subtract(6, 'days'), moment()],
                '过去30天': [moment().subtract(29, 'days'), moment()],
                '本月': [moment().startOf("month"), moment()],
                '上月': [moment().subtract(1, 'months'), moment().subtract(1, 'months').endOf('month')],
            }
        };
       var GetAllEmployee =function () {
           var postData = {
               currentPage: $scope.paginationConf.currentPage,
               itemsPerPage: $scope.paginationConf.itemsPerPage,
               filter: $scope.citySelected,
               // endTime:$scope.date.endDate
           }
           userList.getuser(postData).then(function (us) {
               $scope.users = us.data.list
               $scope.paginationConf.totalItems = us.data.total;
           })
       }
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage + citySelected',  GetAllEmployee);
        $scope.smsOptions = {}
        $scope.smsOptions.labels = ['手淘短链','短信模板']
$scope.smsOptions.content = ''
        $scope.smsOptions.sign_content = '依布旗舰店'
        $scope.diySigns = [{
            value: 1,
            displayName: '依布旗舰店'
        }, {
            value: 2,
            displayName: '科尚旗舰店'
        }]
        $scope.userinfo = ''
       $scope.sendSMS = function (u) {
            $scope.userbuyer = u.buyer_nick
            $scope.userphone = u.buyer_phone
           console.log(u)
           ngDialog.open({
               template: 'kehuModel.html',
               className: 'ngdialog-theme-plain',
               scope: $scope
           });
       }
        var toSMS;
        var messageinfo = "【" +  $scope.smsOptions.sign_content +"】";

       //发送信息
       $scope.validSend = function () {


           // console.log(toSMS)

       }
        $scope.testPhone = '15088909294'

       $scope.validCheck = function () {
           function pad2(n) { return n < 10 ? '0' + n : n }
           var date = new Date();
           var time = date.getFullYear().toString() + pad2(date.getMonth() + 1) + pad2( date.getDate()) + pad2( date.getHours() ) + pad2( date.getMinutes() ) + pad2( date.getSeconds() )
           var md5sig = md5.createHash('847be1780fcb45bc8dc4244c5504d563e087b68b93e94cffad98df7301f33ee3'+time || '')
           console.log(md5sig)
           console.log('check'+time)
           toSMS = messageinfo + $scope.smsOptions.content+'退订回T';
           console.log('check'+toSMS)

           $http.post('https://api.miaodiyun.com/20150822/affMarkSMS/sendSMS?accountSid=847be1780fcb45bc8dc4244c5504d563&smsContent=【依布旗舰店】您有新订单，下单时间为'+moment()+'，请尽快处理,回复N退订。'+'&to=15088909294&timestamp='+time+'&sig='+md5sig+'&respDataType=JSON')
           //13896543210,13965893652,13698568547,18569533265
       }
    })
    })