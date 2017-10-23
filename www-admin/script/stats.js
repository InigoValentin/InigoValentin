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
        maxH = graph.height - 25;

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
            context.fillText(parseInt(values[i], 10), i * graph.width / values.length + (graph.width / values.length) / 2, graph.height - barH - 3);

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
