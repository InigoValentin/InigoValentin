function BarGraph(context) {

    var graph = this;
    this.values = [];
    this.labels = [];

    this.setLabels = function(labels){
        this.labels = labels;
    }

    this.setValues = function(values){
        this.values = values;
    }

    this.draw = function () {

        var values = graph.values;
        var barW;
        var barH;
        var barB = 1; // Border
        var ratio;
        var maxH;
        var max;
        var i;

        // Canvas dimensions
        context.canvas.width = graph.width;
        context.canvas.height = graph.height;

        // Width of each bar
        barW = graph.width / values.length - graph.margin * 2;
        maxH = graph.height - 30;

        // Reference height
        var max = 0;
        for (i = 0; i < values.length; i ++) {
            if (values[i] > max) {
                max = values[i];	
            }
        }

        // Loop bars
        for (i = 0; i < values.length; i ++) {

            // Compare with the max value
            barH = maxH * values[i] / max;
            graph.height -= 15;

            // Value
            context.fillStyle = "#003300";
            context.font = "bold 12px sans-serif";
            context.textAlign = "center";
            context.fillText(parseInt(values[i], 10), i * graph.width / values.length + (graph.width / values.length) / 2, graph.height - barH - 2);

            // Bar background (border)
            context.fillStyle = "#003300";
            context.fillRect(graph.margin + i * graph.width / values.length, graph.height - barH, barW, barH);

            // Bar fill
            context.fillStyle = "#ccffcc";
            context.fillRect(graph.margin + i * graph.width / values.length + barB, graph.height - barH + barB, barW - barB * 2, barH - barB * 2);

            // Label
            graph.height += 15;
            context.fillStyle = "#003300";
            context.font = "10px sans-serif";
            context.textAlign = "center";
            context.fillText(graph.labels[i], i * graph.width / values.length + (graph.width / values.length) / 2, graph.height - 5);
        }
    };

  this.width = 450;
  this.height = 150;
  this.margin = 1;
  
}


function HBarGraph(context) {

    var graph = this;
    this.values = [];
    this.labels = [];

    this.setLabels = function(labels){
        this.labels = labels;
    }

    this.setValues = function(values){
        this.values = values;
    }

    this.draw = function () {

        var values = graph.values;
        var barW;
        var barH;
        var barB = 1; // Border
        var ratio;
        var maxH;
        var max;
        var i;

        // Canvas dimensions
        context.canvas.width = graph.width;
        context.canvas.height = graph.height;

        // Height of each bar
        barH = graph.height / values.length - graph.margin * 2;
        maxW = graph.width - 200;

        // Reference width
        var max = 0;
        for (i = 0; i < values.length; i ++) {
            if (values[i] > max) {
                max = values[i];	
            }
        }

        // Loop bars
        for (i = 0; i < values.length; i ++) {

            // Compare with the max value
            barW = maxW * values[i] / max;

            // Label
            context.fillStyle = "#003300";
            context.font = "10px sans-serif";
            context.textAlign = "right";
            context.fillText(graph.labels[i], 150, barH / 2 + (graph.margin + i * graph.height / values.length));

            // Bar background (border)
            context.fillStyle = "#003300";
            context.fillRect(160, graph.margin + i * graph.height / values.length, barW, barH);

            // Bar fill
            context.fillStyle = "#ccffcc";
            context.fillRect(160 + barB, barB + (graph.margin + i * graph.height / values.length), barW - (2 * barB), barH - (2 * barB));

            // Value
            context.fillStyle = "#003300";
            context.font = "bold 12px sans-serif";
            context.textAlign = "left";
            context.fillText(parseInt(values[i], 10), 170 + barW, barH / 2 + (graph.margin + i * graph.height / values.length));

        }
    };

  this.width = 450;
  this.height = 250;
  this.margin = 1;
  
}


function PieGraph(context) {

    var graph = this;
    this.values = [];
    this.labels = [];

    this.setLabels = function(labels){
        this.labels = labels;
    }

    this.setValues = function(values){
        this.values = values;
    }

    this.draw = function () {

        var values = graph.values;
        var barW;
        var barH;
        var barB = 1; // Border
        var ratio;
        var maxH;
        var max;
        var i;

        // Canvas dimensions
        context.canvas.width = graph.width;
        context.canvas.height = graph.height;

        // Sum of values
        var sum = 0;
        for (i = 0; i < values.length; i ++) {
            sum = sum + values[i]
        }

        // Loop arcs
        var iAngle = (-0.5) * Math.PI;
        var hLegend = 30;
        for (i = 0; i < values.length; i ++) {

            // Calculate angle
            var v = (values[i] * 2  / sum) * Math.PI;

            // Draw arc
            context.fillStyle = "#00" + (3 * (i + 3)).toString().substr(-1) + (3 * (i + 3)).toString().substr(-1) + "00";
            context.strokeStyle = "#00" + (3 * (i + 3)).toString().substr(-1) + (3 * (i + 3)).toString().substr(-1) + "00";
            context.beginPath();
            context.arc(100, 100, 50, iAngle, iAngle + v);
            context.lineWidth = 80;
            context.stroke();

            // Legend
            var label = graph.labels[i] + " (" + (values[i] * 100 / sum).toFixed(2) + "%)";
            context.beginPath();
            context.arc(215, hLegend, 10, 0, 2 * Math.PI);
            context.fill();
            context.font = "10px sans-serif";
            context.textAlign = "left";
            context.fillText(label, 230, hLegend + 5);

            // Prepare for next
            iAngle = iAngle + v;
            hLegend = hLegend + 30;

        }
    };

  this.width = 380;
  this.height = 200;
  this.margin = 1;
  
}
