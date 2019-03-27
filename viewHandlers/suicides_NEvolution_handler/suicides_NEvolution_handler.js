var age = document.getElementById('age');
var country = document.getElementById('country');
var options = document.getElementById('options');

var chart = null;
var total = 1;

var graphOptions = {
    animationEnabled: false,
    title: {
        text: "Total registered suicides over time"
    },
    subtitles: [{
        fontFamily: 'calibri',
		fontSize: 16,
		fontColor: "black",
		padding: 5
    }],
    axisX: {
        crosshair: {
			enabled: true,
			snapToDataPoint: true
        },
        valueFormatString: "####",
        title: "Year"
    },
    axisY: {
		title: "Number of suicides",
		includeZero: false,
		valueFormatString: "##0",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
    data: []
};

var graphData = {
    type: "area",
    xValueFormatString: "####",
    toolTipContent: "<b>Year {x}</b>: {y} suicides",
    showInLegend: false,
    color: "#FFC966",
    dataPoints: []
    
};

function updateOptions(id)
{
    var ageValue = age.value;
    var countryValue = country.value;

    if (id === 'country' || id === 'age')
    {
        if (id !== 'age')
        {
            //AJAX
            var ageRequest = new XMLHttpRequest();

            // Open connection
            ageRequest.open('POST', 'viewHandlers/suicides_NEvolution_handler/suicides_NEvolution_handler_ajax.php', true);
            // Set up handler for when request finishes
            ageRequest.onload = function () {
                if (ageRequest.status === 200) { //200 = OK
                    age.innerHTML = ageRequest.response;
                } else {
                    alert('An error occurred!');
                }
            };
            ageRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            var params = "id=age&country=" + countryValue + "&age=" + ageValue;
            ageRequest.send(params);
        }

        if (id !== 'country')
        {
             var countryRequest = new XMLHttpRequest();

             // Open connection
             countryRequest.open('POST', 'viewHandlers/suicides_NEvolution_handler/suicides_NEvolution_handler_ajax.php', true);
             // Set up handler for when request finishes
             countryRequest.onload = function () {
                 if (countryRequest.status === 200) { //200 = OK
                     country.innerHTML = countryRequest.response;
                 } else {
                     alert('An error occurred!');
                 }
             };

             countryRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            var params = "id=country&country=" + countryValue + "&age=" + ageValue;
            countryRequest.send(params);
        }
        getData();
    }


}

//Realiza una llamada al servidor para obtener los datos de la consulta seleccionada
//data en caso de no ser null será un string con formato JSON con los valores seleccionados.
function getData(data)
{
    if (data != null)
    {
        dataJSON = JSON.parse(data);

        age.value = dataJSON.age;
        country.value = dataJSON.country;
        updateOptions('age');
        updateOptions('country');
    }
    var ageValue = age.value;
    var countryValue = country.value;

    //AJAX
    var dataRequest = new XMLHttpRequest();

    // Open connection
    dataRequest.open('POST', 'viewHandlers/suicides_NEvolution_handler/suicides_NEvolution_handler_ajax.php', true);
    // Set up handler for when request finishes
    dataRequest.onload = function () {
        if (dataRequest.status === 200) { 
            updateData(dataRequest.response);
        } else {
            alert('An error occurred!');
        }
    };

    dataRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var params = "id=data&country=" + countryValue + "&age=" + ageValue;
    dataRequest.send(params);
}

//Genera el gráfico por primera vez
//No hará nada si el gráfico ya está generado
//data en caso de proporcionarse será un string con formato JSON con los valores seleccionados.
function generateGraph(data = null)
{
    if (chart == null){
        chart = new CanvasJS.Chart("chartContainer", graphOptions);
        chart.options.data[0] = graphData;
        getData(data);
        console.log(data);
    }
}

function updateData(newData)
{
    if (chart != null)
    {
        var ageValue = age.value;
        var countryValue = country.value;

        console.log(newData)
        newDataJSON =  JSON.parse(newData);
        total = (newDataJSON[0].y + newDataJSON[1].y);
        chart.options.subtitles[0].text = (countryValue === 'Any' ? 'International' : countryValue) + ', ' + 
                                          (ageValue === 'Any' ? 'all ages' : ageValue);

        chart.options.data[0].dataPoints = newDataJSON;
        chart.render(); 
        console.log(chart.options.data);
        
    }
}

function saveView(id, view)
{
    var ageValue = age.value;
    var countryValue = country.value;

    var saveRequest = new XMLHttpRequest();

    // Open connection
    saveRequest.open('POST', 'includes/saveViewAjax.php', true);
    // Set up handler for when request finishes
    saveRequest.onload = function () {
        if (saveRequest.status === 200) { //200 = OK
            if (saveRequest.response == "ok")
                Snackbar.show({text: 'View saved, you can see it in "My views".'});
            else if (saveRequest.response == "No hay sesión iniciada.")
                Snackbar.show({text: 'You must Log in to save graphs', actionTextColor: '#ED2939'});
            else
                Snackbar.show({text: 'An error ocurred!', backgroundColor: '#7C0A02', actionTextColor: '#FFFFFF'});
        } else {
            Snackbar.show({text: 'An connection error ocurred!', backgroundColor: '#7C0A02', actionTextColor: '#FFFFFF'});
        }
    };
    saveRequest.setRequestHeader("Content-Type", "application/json");
    var data = JSON.stringify({"country": countryValue, "age": ageValue});
    saveRequest.send(JSON.stringify({"view":view, "dataset":id, "data":data}));

}