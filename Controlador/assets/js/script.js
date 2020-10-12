function converMySqlDate(dateTime) {
    if (dateTime) {
        let dateTimeParts = dateTime.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
        //dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
        //const dateObject = new Date(...dateTimeParts); // our Date object.
        const dateObject = `${dateTimeParts[2]}-${dateTimeParts[1]}-${dateTimeParts[0]} `;
        return dateObject;
    } else {
        return "";
    }
}

function converMySqlDateTime(dateTime) {
    if (dateTime) {
        let dateTimeParts = dateTime.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
        //dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
        //const dateObject = new Date(...dateTimeParts); // our Date object.
        const dateObject = `${dateTimeParts[2]}-${dateTimeParts[1]}-${dateTimeParts[0]} ${dateTimeParts[3]}:${dateTimeParts[4]}`;
        return dateObject;
    } else {
        return "";
    }

}