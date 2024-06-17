const convertGeneratedResponse = (text) => {
    text = text.replace(
        /\*\*(.*?)\*\*/g,
        "<br><strong class='underline'>$1</strong>"
    );
    text = text.replace(/\*/g, "<br>");
    return text;
};

export default convertGeneratedResponse;
