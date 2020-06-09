// This class is used to get a response from the server, this will help tidy up code

function checkUsernameFromServer(formdata)
{
    const response = axios(
    {
        method: 'post',
        url: '../User/userController.php',
        data: formdata,
        headers: {'Content-Type': 'multipart/form-data' }
    })

    return response;
}

function loadProjectsFromServer()
{
    var data = new FormData();
    data.append('function', "loadProjects");

    const response = axios(
    {
        method: 'post',
        url: '../Project/projectController.php',
        data: formdata,
        headers: {'Content-Type': 'multipart/form-data' }
    })

    return response;
}

function loadTicketsFromServer(id)
{
    const response = axios(
        {
            method: 'get',
            url: '../Project/projectController.php?projectId='+id,
            headers: {'Content-Type': 'multipart/form-data' }
        })
    
        return response;
}

function loadAssigneeFromServer(ticketId)
{
    var formData = new FormData();
    formData.append('function', "loadAssignee");
    formData.append('ticketId', ticketId);

    const response = axios(
        {
            method: 'post',
            data: formData,
            url: '../Ticket/ticketController.php',
            headers: {'Content-Type': 'multipart/form-data' }
        })
    
        return response;
}

function loadReporterFromServer(ticketId)
{
    var data = new FormData();
    data.append('function', "loadReporter");
    data.append('ticketId', ticketId);

    const response = axios(
        {
            method: 'post',
            data: data,
            url: '../Ticket/ticketController.php',
            headers: {'Content-Type': 'multipart/form-data' }
        })
    
        return response;
}

function getActiveUsersFromServer()
{
    var data = new FormData();
    data.append('function', "getActiveUsers");

    const response = axios(
        {
            method: 'post',
            data: data,
            url: '../User/userController.php',
            headers: {'Content-Type': 'multipart/form-data' }
        })
    
        return response;
}

function loadCommentsFromServer(ticketId)
{
    var data = new FormData();
    data.append('function', "loadComments");
    data.append('ticketId', ticketId);

    const response = axios(
        {
            method: 'post',
            data: data,
            url: '../Ticket/ticketController.php',
            headers: {'Content-Type': 'multipart/form-data' }
        })
    
        return response;
}

function loadDatesFromServer(ticketId)
{
    var data = new FormData();
    data.append('function', "loadDates");
    data.append('ticketId', ticketId);

    const response = axios(
        {
            method: 'post',
            data: data,
            url: '../Ticket/ticketController.php',
            headers: {'Content-Type': 'multipart/form-data' }
        })
    
        return response;
}