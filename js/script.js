async function postRequest(array, scriptUrl) {
    try {
        const formBody = new URLSearchParams();
        for (const key in array) {
            formBody.append(`data[${key}]`, array[key]); // pass as arr[name], arr[email], etc.
        }

        const response = await fetch(scriptUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formBody.toString()
        });

        if (!response.ok) {
            throw new Error(`Server responded with status ${response.status}`);
        }

        const responseText = await response.text(); 
        return responseText;
    } catch (error) {
        console.error('Error during AJAX call:', error);
        throw error;
    }
}
