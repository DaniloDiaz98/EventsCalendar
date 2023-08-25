const answer = document.getElementById("answer_user1");
const btnReply = document.getElementById("question__reply");
btnReply.addEventListener("click", () => {
  answer.classList.toggle("answer-disable");
});
