<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Incident Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</head>
<body>

<div class="container" style="width:90%; margin:50px auto;">
    <h2>📊 Fire Incidents (Past 2 Years & Current Year)</h2>
    <canvas id="fireChart" height="120"></canvas>
</div>

<script>
// Sample data for demonstration (past 2 years + current year)
const currentYear = new Date().getFullYear();
const years = [currentYear - 2, currentYear - 1, currentYear];

const yearlyData = {
    [currentYear - 2]: { OPFMSL: 10, MDFI: 5, RESIDENTIAL: 8, 'NON-RESIDENTIAL': 4, STRUCTURAL: 3, 'NON-STRUCTURAL': 2, TRANSPORT: 1 },
    [currentYear - 1]: { OPFMSL: 12, MDFI: 6, RESIDENTIAL: 9, 'NON-RESIDENTIAL': 5, STRUCTURAL: 4, 'NON-STRUCTURAL': 3, TRANSPORT: 2 },
    [currentYear]: { OPFMSL: 15, MDFI: 7, RESIDENTIAL: 11, 'NON-RESIDENTIAL': 6, STRUCTURAL: 5, 'NON-STRUCTURAL': 4, TRANSPORT: 3 }
};

const labels = years;
const datasetOPFMSL = labels.map(y => yearlyData[y].OPFMSL);
const datasetMDFI = labels.map(y => yearlyData[y].MDFI);
const datasetRES = labels.map(y => yearlyData[y].RESIDENTIAL);
const datasetNONRES = labels.map(y => yearlyData[y]['NON-RESIDENTIAL']);
const datasetSTR = labels.map(y => yearlyData[y].STRUCTURAL);
const datasetNONSTR = labels.map(y => yearlyData[y]['NON-STRUCTURAL']);
const datasetTRANS = labels.map(y => yearlyData[y].TRANSPORT);

new Chart(document.getElementById('fireChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            { label: 'OPFMSL', data: datasetOPFMSL, backgroundColor: 'rgba(255, 99, 132, 0.7)' },
            { label: 'MDFI', data: datasetMDFI, backgroundColor: 'rgba(54, 162, 235, 0.7)' },
            { label: 'RESIDENTIAL', data: datasetRES, backgroundColor: 'rgba(75, 192, 192, 0.7)' },
            { label: 'NON-RESIDENTIAL', data: datasetNONRES, backgroundColor: 'rgba(153, 102, 255, 0.7)' },
            { label: 'STRUCTURAL', data: datasetSTR, backgroundColor: 'rgba(255, 159, 64, 0.7)' },
            { label: 'NON-STRUCTURAL', data: datasetNONSTR, backgroundColor: 'rgba(165, 42, 42, 0.7)' },
            { label: 'TRANSPORT', data: datasetTRANS, backgroundColor: 'rgba(0, 0, 0, 0.7)' }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: (value) => value,
                font: { weight: 'bold', size: 12 }
            },
            tooltip: {
                callbacks: {
                    label: function(context) { return context.dataset.label + ': ' + context.parsed.y; }
                }
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } },
            x: { stacked: false },
        }
    },
    plugins: [ChartDataLabels]
});
</script>

</body>
</html>