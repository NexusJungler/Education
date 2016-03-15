
//Chart.defaults.global.responsive = true;
var graph = {
    labels: ["Francais" , "Langue", "Maths", "Techniques de l'information", "Culture humaniste", "Social et Civisme", "Autonomie"],
    datasets: [
        {
            label: "Reference",
            fillColor: "rgba(255,255,66,0.4)",
            strokeColor: "rgba(255,255,66,1)",
            pointColor: "rgba(255,255,66,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,255,66,1)",
            data: [65, 59, 90, 81, 56, 55, 40]
        },
        {
            label: "Eleve",
            fillColor: "rgba(0,102,204,0.4)",
            strokeColor:"rgba(0,102,204,1)",
            pointColor:"rgba(0,102,204,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(0,102,204,1)",
            data:[68, 48, 40, 19, 96, 27, 42]
        }
    ],
    init: function(entry) {
        this.datasets[1].data = entry;
    }
};


/* labels: ["Ma�trise de la langue fran�aise", "Pratique d'une langue vivante �trang�re", "Principaux �l�ments de math�matiques et la culture scientifique et technologique", "Ma�trise des techniques usuelles de l'information", "Culture humaniste", "Comp�tences sociales et civiques", "Autonomie et initiative"],     */