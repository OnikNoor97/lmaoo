function tidyUpTimestamp(timestamp) 
{
  var dateCreated = new Date(timestamp); dateCreated.toString();
  var date = dateCreated.getDate();
  var month = dateCreated.getMonth() + 1; // getMonths start with index 0 
  var year = dateCreated.getFullYear();
  var hours = dateCreated.getHours() > 12 ? dateCreated.getHours() - 12 : dateCreated.getHours();
  var minutes = dateCreated.getMinutes() < 10 ? "0" + dateCreated.getMinutes() : dateCreated.getMinutes(); // to add 0 from 0-9 minutes
  var ampm = dateCreated.getHours() >= 12 ? "PM" : "AM";

  return `${date}/${month}/${year} ${hours}:${minutes} ${ampm}`;
}

function loadDates()
{
  // To be implemented -> Remember: This file will be deleted
}