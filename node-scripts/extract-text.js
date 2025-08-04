const textract = require('textract');

const filePath = process.argv[2];

if (!filePath) {
    console.error('Please provide the path to the file');
    process.exit(1);
}

textract.fromFileWithPath(filePath, (error, text) => {
    if (error) {
        console.error(error);
        process.exit(1);
    }
    console.log(text);
});
