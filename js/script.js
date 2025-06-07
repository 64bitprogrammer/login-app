async function postRequest(array, scriptUrl) {
    try {
        const response = await fetch(scriptUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ data: array }) // sending array inside an object for structure
        });

        if (!response.ok) {
            throw new Error(`Server responded with status ${response.status}`);
        }

        const jsonResponse = await response.json(); // parse JSON response
        return JSON.stringify(jsonResponse); // return as JSON string
    } catch (error) {
        console.error('Error during AJAX call:', error);
        throw error; // rethrow error to be handled by caller
    }
}