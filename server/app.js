var express = require("express");
var app = express();
var path = require("path");
var mime = require("mime");
const axios = require("axios");
const { JSDOM } = require("jsdom");

// Serve static files from the 'public' directory
app.use(express.static(path.join(__dirname + '/../'), {
  setHeaders: function (res, path) {
    if (mime.getType(path) === 'text/javascript') {
      res.setHeader('Content-Type', 'text/javascript');
      res.setHeader('Content-Security-Policy', "script-src 'self' https://cdn.babylonjs.com https://code.jquery.com");
    }
  }
}));

// Serve the index.html file
app.get('/', function(req, res) {
  res.sendFile(path.join(__dirname+'/../index.html'));
});

// New route for modified iframe
app.get('/modified-iframe', async (req, res) => {
  try {
    const response = await axios.get("https://lumalabs.ai/embed/f8d5ff31-4d4a-4aa8-bbaf-ce1b8173d7fc?mode=sparkles...");
    const dom = new JSDOM(response.data);
    const document = dom.window.document;

    // Remove the specified elements
    const imgElement = document.querySelector('img');
    if (imgElement) imgElement.remove();

    const infoContainer = document.querySelector('.info_container__9cFHC');
    if (infoContainer) infoContainer.remove();

    res.send(dom.serialize());
  } catch (error) {
    console.error("Error fetching or modifying iframe content:", error);
    res.status(500).send("Error processing your request");
  }
});

app.listen(3000, () => {
  console.log("Running at Port 3000");
});
