import "./bootstrap.js";
import "./styles/app.css";

addEventListener("turbo:frame-render", (event) => {
  if (event.detail.fetchResponse.location.pathname === "/") {
    document
      .getElementsByClassName("modal-container")[0]
      .classList.add("modal-hidden");
  } else {
    document
      .getElementsByClassName("modal-container")[0]
      .classList.remove("modal-hidden");
  }
});
