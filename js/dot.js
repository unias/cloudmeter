var width = 800;
var height = 400;
var instance = ['ecs.g5.large', 'ecs.g5.xlarge', 'ecs.g5.2xlarge', 'ecs.g5.3xlarge', 'ecs.c5.large', 'ecs.c5.xlarge',
    'ecs.c5.2xlarge', 'ecs.c5.3xlarge', 'ecs.r5.large', 'ecs.r5.xlarge', 'ecs.r5.2xlarge', 'ecs.r5.3xlarge',
    'ecs.d1ne.2xlarge', 'ecs.i2g.2xlarge', 'ecs.i2.xlarge', 'ecs.i2.2xlarge', 'ecs.hfg5.large', 'ecs.hfg5.xlarge',
    'ecs.hfg5.2xlarge', 'ecs.hfg5.3xlarge', 'ecs.hfc5.large', 'ecs.hfc5.xlarge', 'ecs.hfc5.2xlarge', 'ecs.hfc5.3xlarge'];
function doit() {
    d3.csv("json/ycsb_data.csv", function (data) {                     // d3.csv从csv文件中读取数据，得到一个 对象数组
        var y_value = $("#y_axis").val();
        var wl_value = $("#wl_axis").val();
        var db_value = $("#db_axis").val();
        var dataset = [];
        var names = []
        for (let t of instance) {
            let value = t + " ycsb " + wl_value + " " + db_value;
            names.push(value);
        }
        for (let item of data) {
            if (names.indexOf("ecs." + item["Name"]) >= 0) {
                dataset.push([instance.indexOf("ecs." + item["Name"].split(" ")[0]) + 1, parseInt(item[y_value])]);
            }
        }
        var padding = { left: 50, right: 30, top: 30, bottom: 30 };
        var svg = d3.select("#mySVG")
            .append("svg")
            .attr("width", width)
            .attr("height", height);

        var xScale = d3.scale.linear()
            .domain([0, 1.2 * 24])
            .range([0, width - padding.left - padding.right]);

        var yScale = d3.scale.linear()
            .domain([(d3.min(dataset, function (d) {
                return d[1];
            }) / 2), d3.max(dataset, function (d) {
                return d[1];
            })])
            .range([height - padding.top - padding.bottom, 0]);

        var circle = svg.selectAll("circle")
            .data(dataset)
            .enter()
            .append("circle")
            .attr("fill", "black")
            .attr("cx", function (d) {
                return padding.left + xScale(d[0]);//设置圆心x坐标
            })
            .attr("cy", function (d) {

                return yScale(d[1]) + padding.bottom;
                //调节y的值  调了好久 
                //需要与设置的y轴的坐标相对应
            })
            .attr("r", 5);//半径

        //定义x轴
        var xAxis = d3.svg.axis()
            .scale(xScale)
            .orient("bottom");//坐标轴方向
        //定义Y轴
        var yAxis = d3.svg.axis()
            .scale(yScale)
            .orient("left");

        //添加X轴
        svg.append("g")
            .attr("class", "axis")
            .attr("transform", "translate(" + padding.left + "," + (height - padding.bottom) + ")")
            .call(xAxis);

        //添加y轴
        svg.append("g")
            .attr("class", "axis")
            .attr("transform", "translate(" + padding.left + "," + padding.top + ")")
            // .attr("transform","translate("+padding.left+(height-padding.bottom-yAxisWidth)+")")
            .call(yAxis);

    });
}

doit();

$("#wl_axis, #db_axis, #y_axis").on("change", function () {
    d3.selectAll("svg").remove();
    doit();
});
