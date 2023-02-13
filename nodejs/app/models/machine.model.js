module.exports = (sequelize, Sequelize) => {
  const machineList = sequelize.define("machines", {
    user_id: {
      type: Sequelize.INTEGER
    },
    access_key: {
      type: Sequelize.STRING
    },
    secret_key: {
      type: Sequelize.STRING
    },
    category: {
      type: Sequelize.STRING
    },
    down: {
      type: Sequelize.INTEGER
    },
    web_hook: {
      type: Sequelize.INTEGER
    },
    is_reg: {
      type: Sequelize.INTEGER
    },
    reg_num: {
      type: Sequelize.INTEGER
    },
    trk_num: {
      type: Sequelize.INTEGER
    },
    file_name: {
      type: Sequelize.STRING
    },
    len: {
      type: Sequelize.INTEGER
    },
    round: {
      type: Sequelize.INTEGER
    },
    stop: {
      type: Sequelize.INTEGER
    },
  },
  { 
    timestamps: false
  });
  return machineList;
};