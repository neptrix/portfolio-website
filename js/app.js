const passwordInput = document.getElementById("password");
const passwordStrength = document.getElementById("password-strength");

passwordInput.addEventListener("input", () => {
  const password = passwordInput.value;
  const strength = getPasswordStrength(password);

  switch (strength) {
    case "strong":
      passwordStrength.textContent = "Password strength: Strong";
      passwordStrength.style.color = "green";
      break;
    default:
      passwordStrength.textContent = 'Password strength: '+getPasswordStrength(password);
      passwordStrength.style.color = "red";
  }
});

function getPasswordStrength(password) {
  const lengthRegex = /.{8,}/; // at least 8 characters
  const uppercaseRegex = /[A-Z]/; // at least one uppercase letter
  const lowercaseRegex = /[a-z]/; // at least one lowercase letter
  const numberRegex = /[0-9]/; // at least one number
  const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/; // at least one special character

  let enter = [];
  
  if (!lengthRegex.test(password)) {
    enter.push("at least 8 characters");
  }

  if (!uppercaseRegex.test(password)) {
    enter.push("at least one uppercase letter");
  }

  if (!lowercaseRegex.test(password)) {
    enter.push("at least one lowercase letter");
  }

  if (!numberRegex.test(password)) {
    enter.push("at least one number");
  }

  if (!specialCharRegex.test(password)) {
    enter.push("at least one special character");
  }

  if (enter.length === 0) {
    return "strong";
  } else {
    return "Weak (Enter: " + enter.join(", ") +')';
  }

}
