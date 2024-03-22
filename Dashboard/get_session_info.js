async function fetchSessionInfo() {
    try {
        let response = await fetch('session_info.php');
        let data = await response.json();
        console.log('Session info:', data);
        return data;
    } catch (error) {
        console.error('Error:', error);
    }
}
