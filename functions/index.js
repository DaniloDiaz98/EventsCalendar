const functions = require("firebase-functions");
const admin = require("firebase-admin");
const nodemailer = require("nodemailer");

admin.initializeApp();

const transporter = nodemailer.createTransport({
  service: "Gmail",
  auth: {
    user: "tu_correo@gmail.com",
    pass: "tu_contraseña",
  },
});

exports.sendConfirmationEmail = functions.database.ref("/usuarios/{userId}").onCreate((snapshot, context) => {
  const user = snapshot.val();

  const mailOptions = {
    from: "tu_correo@gmail.com",
    to: user.email,
    subject: "Confirmación de Registro",
    text: `Tu token de confirmación es: ${user.token}`,
  };

  return transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.log("Error al enviar el correo:", error);
    } else {
      console.log("Correo electrónico enviado:", info.response);
    }
  });
});
