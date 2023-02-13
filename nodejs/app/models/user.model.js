module.exports = (sequelize, Sequelize) => {
  const userList = sequelize.define("users", {
    email: {
      type: Sequelize.STRING
    },
    _token: {
      type: Sequelize.STRING
    },
    password: {
      type: Sequelize.STRING
    },
    role: {
      type: Sequelize.STRING
    },
    family_name: {
      type: Sequelize.STRING
    },
    line_id: {
      type: Sequelize.STRING
    },
    discord_id: {
      type: Sequelize.STRING
    },
  },
  { 
    timestamps: false
  });
  return userList;
};