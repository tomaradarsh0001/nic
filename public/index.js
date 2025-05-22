$(function () {
  "use strict";
  

  // chart 0

  var ctx = document.getElementById("chartProperties1").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#64B5F6');
  // gradientStroke1.addColorStop(1, '#17c5ea');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#81C784');
  // gradientStroke2.addColorStop(1, '#ffdf40');

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      // labels: ['No. of Properties'],
      datasets: [{
        label: 'Nazul',
        data: [65, 68],
        borderColor: gradientStroke1,
        backgroundColor: gradientStroke1,
        hoverBackgroundColor: gradientStroke1,
        pointRadius: 0,
        fill: false,
        borderWidth: 0
      },
      {
        label: 'Rehabilitation',
        data: [42, 23],
        borderColor: gradientStroke2,
        backgroundColor: gradientStroke2,
        hoverBackgroundColor: gradientStroke2,
        pointRadius: 0,
        fill: false,
        borderWidth: 0
      }]
    },

    options: {
      plugins: {
        datalabels: {
          color: '#fff',
          font: {
            size: 18
          }
        }
      },
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        display: true,
        labels: {
          boxWidth: 8
        }
      },
      tooltips: {
        displayColors: true,
        display: true
      },
      scales: {
        xAxes: [{
          barPercentage: .5
        }]
      }
    }
  });

  // chart 01

  var ctx = document.getElementById("chartAreaProperties1").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#64B5F6');
  // gradientStroke1.addColorStop(1, '#17c5ea'); 

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#E57373');
  // gradientStroke2.addColorStop(1, '#ffdf40');

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['0-50', '51-100', '151-250', '251-350', '351-500', '501-750', '751 - 1000', '1001 - 2000', '> 2000'],
      datasets: [{
        label: 'Nazul',
        data: [65, 45, 24, 98, 78, 156, 197, 168, 184],
        borderColor: gradientStroke1,
        backgroundColor: gradientStroke1,
        hoverBackgroundColor: gradientStroke1,
        pointRadius: 0,
        fill: false,
        borderWidth: 0
      },
      {
        label: 'Rehabilitation',
        data: [75, 45, 24, 98, 65, 87, 245, 185, 171],
        borderColor: gradientStroke2,
        backgroundColor: gradientStroke2,
        hoverBackgroundColor: gradientStroke2,
        pointRadius: 1,
        fill: false,
        borderWidth: 1
      }]
    },

    options: {
      plugins: {
        datalabels: {
          color: '#fff',
          font: {
            size: 18
          }
        }
      },
      maintainAspectRatio: false,
      legend: {
        position: 'top',
        display: false,
        labels: {
          boxWidth: 0
        }
      },
      tooltips: {
        displayColors: false,
      },
      scales: {
        XAxes: [{
          barPercentage: .5
        }]
      }
    }
  });

  // land value

  var ctx = document.getElementById("landvalue").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#81C784');
  // gradientStroke1.addColorStop(1, '#17c5ea'); 

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#81C784');
  // gradientStroke2.addColorStop(1, '#ffdf40');

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['> 50L', '50L - 1Cr', '1Cr - 5Cr', '5Cr - 10Cr', '10Cr - 50Cr', '50Cr - 100Cr', '100Cr - 500Cr', '500Cr <'],
      datasets: [{
        label: 'Land Value',
        data: [565, 59, 80, 981, 65, 59, 80, 81, 59, 80, 81, 65],
        borderColor: gradientStroke1,
        backgroundColor: gradientStroke1,
        hoverBackgroundColor: gradientStroke1,
        pointRadius: 0,
        fill: false,
        borderWidth: 0
      }]
    },

    options: {
      plugins: {
        datalabels: {
          color: '#fff',
          font: {
            size: 18
          }
        }
      },
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        display: false,
        labels: {
          boxWidth: 2
        }
      },
      tooltips: {
        displayColors: false,
      },
      scales: {
        xAxes: [{
          barPercentage: .5
        }]
      }
    }
  });

  //  Revenue INR
const topLabels = {
  id: 'topLabels',
  afterDatasetsDraw(chart, args, pluginOptions) {
    const {ctx, scales: {x, y} } = chart;
    ctx.font = 'bold 12px sans-serif';
    ctx.fillStyle = 'blue';
    ctx.fillText('19', 100, 100)
  }
}
  var ctx = document.getElementById("revenueINR").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["2019", "2020", "2021", "2022", "2023", "2024"],
      datasets: [{
        label: 'Ground Rent',
        backgroundColor: "#2196F3",
        data: [12, 59, 5, 56, 58, 12],
      }, {
        label: 'Conversion',
        backgroundColor: "#BA68C8",
        data: [12, 59, 5, 56, 58, 12],
      }, {
        label: 'Demand',
        backgroundColor: "#81C784",
        data: [12, 59, 5, 56, 58, 12],
      }, {
        label: 'Breaches',
        backgroundColor: "#E57373",
        data: [12, 59, 5, 56, 58, 12],
      }, {
        label: 'Interest/Penalty',
        backgroundColor: "#FFB74D",
        data: [12, 59, 5, 56, 58, 12],
      }, {
        label: 'Others',
        backgroundColor: "#F06292",
        data: [12, 59, 5, 56, 58, 40],
      }],
    },
    options: {
      plugins: {
        datalabels: {
          color: '#fff'
        }
      },
      cornerRadius: 0,
      tooltips: {
        displayColors: true,
        callbacks: {
          mode: 'x',
        },
      },
      scales: {
        xAxes: [{
          stacked: true,
          gridLines: {
            display: false,
          }
        }],
        yAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
          },
          type: 'linear',
        }]
      },
      responsive: true,
      maintainAspectRatio: false,
      legend: { position: 'top' },
    }
    
  });


  // chart 2

  var ctx = document.getElementById("chart2").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#0450C6');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#64B5F6');

  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Nazul", "Rehabilitation"],
      datasets: [{
        backgroundColor: [
          gradientStroke1,
          gradientStroke2,
        ],
        hoverBackgroundColor: [
          gradientStroke1,
          gradientStroke2,
        ],
        data: [60, 80],
        borderWidth: [1, 1]
      }]
    },
    options: {
      plugins: {
        datalabels: {
          color: '#fff',
          font: {
            size: 18
          }
        }
      },
      maintainAspectRatio: true,
      cutoutPercentage: 60,
      legend: {
        position: 'right',
        display: false,
        labels: {
          boxWidth: 10
        }
      },
      tooltips: {
        displayColors: false,
      }
    }
  });

  var ctx = document.getElementById("chartDoughnut2").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#0450C6');
  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#64B5F6');

  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Nazul", "Rehabilitation"],
      datasets: [{
        backgroundColor: [
          gradientStroke1,
          gradientStroke2,
          // gradientStroke3,
          // gradientStroke4
        ],
        hoverBackgroundColor: [
          gradientStroke1,
          gradientStroke2,
          // gradientStroke3,
          // gradientStroke4
        ],
        data: [70, 80],
        borderWidth: [1, 1]
      }]
    },
    options: {
      plugins: {
        datalabels: {
          color: '#fff',
          font: {
            size: 18
          }
        }
      },
      cornerRadius: 0,
      maintainAspectRatio: true,
      cutoutPercentage: 60,
      legend: {
        position: 'right',
        display: false,
        labels: {
          boxWidth: 10
        }
      },
      tooltips: {
        displayColors: false,
      }
    }
  });


  // No Of Properties
  new Chart(document.getElementById("noofproperties"), {
    type: 'horizontalBar',
    data: {
      labels: ["500Cr <", "100Cr - 500Cr", "50Cr - 100Cr", "10Cr - 50Cr", "5Cr - 10Cr", "1Cr - 5Cr", "50L - 1Cr", "> 50L"],
      datasets: [{
        label: "Rehabilitation",
        backgroundColor: ["#FFB74D", "#FFB74D", "#FFB74D", "#FFB74D", "#FFB74D", "#FFB74D", "#FFB74D", "#FFB74D"],
        data: [455, 984, 456, 789, 879, 213, 891, 542]
      },
      {
        label: "Nazul",
        backgroundColor: ["#64B5F6", "#64B5F6", "#64B5F6", "#64B5F6", "#64B5F6", "#64B5F6", "#64B5F6", "#64B5F6"],
        data: [311, 456, 785, 974, 870, 794, 789, 654]
      }]
    },
    options: {
      plugins: {
        datalabels: {
          color: '#000'
        }
      },
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      title: {
        display: false,
        text: 'No. of Properties'
      },
      datalabels: {
        anchor: 'end',
        align: 'top',
        formatter: function(value, context) {
          return value;
        }
      },
      cornerRadius: 0
    }
  });

  // User Visits


  var ctx = document.getElementById('uservisits').getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#2196F3');
  gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#81C784');
  gradientStroke2.addColorStop(1, 'rgba(129, 199, 132, 0.1)');


  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      datasets: [{
        label: 'New Visitors',
        data: [3, 5, 6],
        pointBorderWidth: 2,
        pointHoverBackgroundColor: gradientStroke1,
        backgroundColor: gradientStroke1,
        borderColor: gradientStroke1,
        borderWidth: 3
      },
      {
        label: 'Returning Visitors',
        data: [1, 4, 3],
        pointBorderWidth: 2,
        pointHoverBackgroundColor: gradientStroke2,
        backgroundColor: gradientStroke2,
        borderColor: gradientStroke2,
        borderWidth: 3
      }]
    },
    options: {
      plugins: {
        datalabels: {
          color: '#000',
          font: {
            size: 18
          }
        }
      },
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        display: false
      },
      tooltips: {
        displayColors: false,
        mode: 'nearest',
        intersect: false,
        position: 'nearest',
        xPadding: 10,
        yPadding: 10,
        caretPadding: 10
      }
    }
  });
  // End


  // chart 4

  var ctx = document.getElementById("chart4").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#ee0979');
  gradientStroke1.addColorStop(1, '#ff6a00');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#283c86');
  gradientStroke2.addColorStop(1, '#39bd3c');

  var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke3.addColorStop(0, '#7f00ff');
  gradientStroke3.addColorStop(1, '#e100ff');

  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Completed", "Pending", "Process"],
      datasets: [{
        backgroundColor: [
          gradientStroke1,
          gradientStroke2,
          gradientStroke3
        ],

        hoverBackgroundColor: [
          gradientStroke1,
          gradientStroke2,
          gradientStroke3
        ],

        data: [50, 50, 50],
        borderWidth: [1, 1, 1]
      }]
    },
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 0,
      legend: {
        position: 'bottom',
        display: false,
        labels: {
          boxWidth: 8
        }
      },
      tooltips: {
        displayColors: false,
      },
    }
  });


  // chart 5

  var ctx = document.getElementById("chart5").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#f54ea2');
  gradientStroke1.addColorStop(1, '#ff7676');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(0, '#42e695');
  gradientStroke2.addColorStop(1, '#3bb2b8');

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [1, 2, 3, 4, 5, 6, 7, 8],
      datasets: [{
        label: 'Clothing',
        data: [40, 30, 60, 35, 60, 25, 50, 40],
        borderColor: gradientStroke1,
        backgroundColor: gradientStroke1,
        hoverBackgroundColor: gradientStroke1,
        pointRadius: 0,
        fill: false,
        borderWidth: 1
      }, {
        label: 'Electronic',
        data: [50, 60, 40, 70, 35, 75, 30, 20],
        borderColor: gradientStroke2,
        backgroundColor: gradientStroke2,
        hoverBackgroundColor: gradientStroke2,
        pointRadius: 0,
        fill: false,
        borderWidth: 1
      }]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        display: false,
        labels: {
          boxWidth: 8
        }
      },
      scales: {
        xAxes: [{
          barPercentage: .5
        }]
      },
      tooltips: {
        displayColors: false,
      }
    }
  });




});
