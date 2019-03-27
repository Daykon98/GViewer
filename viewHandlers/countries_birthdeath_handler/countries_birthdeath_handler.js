
var country = document.getElementById('country');

var chart = null;
var total = 1;

var graphOptions = {
    animationEnabled: false,
    theme: "ligth1",
    title: {
        text: "Birthrate vs deathrate"
    },
    subtitles: [{
        fontFamily: 'calibri',
		fontSize: 16,
		fontColor: "black",
		padding: 5
	}],
    data: []
};

var graphData = {
    type: "column",
    startAngle: 0,
    indexLabelFontSize: 16,
    indexLabel: "",
    dataPoints: []
};

function updateOptions(id)
{
    getData();
}

//Realiza una llamada al servidor para obtener los datos de la consulta seleccionada
//data en caso de no ser null será un string con formato JSON con los valores seleccionados.
function getData(data)
{
    if (data != null)
    {
        console.log(data);
        dataJSON = JSON.parse(data);

        country.value = dataJSON.country;
    }
    var countryValue = country.value;

    //AJAX
    var dataRequest = new XMLHttpRequest();

    // Open connection
    dataRequest.open('POST', 'viewHandlers/countries_birthdeath_handler/countries_birthdeath_handler_ajax.php', true);
    // Set up handler for when request finishes
    dataRequest.onload = function () {
        if (dataRequest.status === 200) { 
            updateData(dataRequest.response);
        } else {
            alert('An error occurred!');
        }
    };

    dataRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var params = "country=" + countryValue;
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

        var countryValue = country.value;

        console.log(newData)
        newDataJSON =  JSON.parse(newData);
        total = (newDataJSON[0].y + newDataJSON[1].y);
        chart.options.subtitles[0].text = countryValue;

        chart.options.data[0].dataPoints = newDataJSON;
        chart.render(); 
        console.log(chart.options.data);
        
    }
}

function saveView(id, view)
{
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
    var data = JSON.stringify({"country": countryValue});
    saveRequest.send(JSON.stringify({"view":view, "dataset":id, "data":data}));

}