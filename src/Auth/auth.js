import { ref } from "vue";

const authState = {
  isLoggedIn: ref(sessionStorage.getItem("isLoggedIn") === "true"),
  email: ref(sessionStorage.getItem("email") || ""),
};

const auth = {
  get isLoggedIn() {
    return authState.isLoggedIn.value;
  },

  get email() {
    return authState.email.value;
  },

  login(user) {
    authState.isLoggedIn.value = true;
    authState.email.value = user;
    sessionStorage.setItem("isLoggedIn", "true");
    sessionStorage.setItem("email", user);
  },

  logout() {
    authState.isLoggedIn.value = false;
    authState.email.value = "";
    sessionStorage.removeItem("isLoggedIn");
    sessionStorage.removeItem("email");
  },
};

export default auth;
