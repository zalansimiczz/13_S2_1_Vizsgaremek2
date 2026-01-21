using MySqlConnector;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace TollÚtdíj
{
    public partial class jarmukezeles : Form
    {
        private readonly string role;
        private readonly int cegId;
        public jarmukezeles(string role, int cegId)
        {
            InitializeComponent();
            this.role = role;
            this.cegId = cegId;
            lblcegid.Visible = false;
            txbcegid.Visible = false;
            cbbjarmulista.DropDownStyle = ComboBoxStyle.DropDownList;


            if (role == "operator")
            {
                this.Text = "Jármű kezelés - Operátor";
                
            }
            else if (role == "ceg_admin")
            {
                this.Text = "Jármű kezelés - Adminisztrátor";
            }
            else if (role == "rendszer_admin")
            {
                this.Text = "Jármű kezelés - Rendszer adminisztrátor";
                lblcegid.Visible = false;
                txbcegid.Visible = false;
            }
        }

        private void jarmukezeles_Load(object sender, EventArgs e)
        {
            MySqlConnectionStringBuilder build = new MySqlConnectionStringBuilder
            {
                Server = "localhost",
                UserID = "root",
                Password = "mysql",
                Database = "tollutdijadatbazis"
            };
            using (MySqlConnection kapcsolat = new MySqlConnection(build.ConnectionString))
            {
                try
                {
                    kapcsolat.Open();
                }
                catch (Exception)
                {
                    lblhiba.Text = "Adatbetöltési hiba.\r\nEllenőrizze az internetkapcsolatot, majd próbálja újra.";
                    lblhiba.Visible = true;
                    return;
                }
                var parancs = kapcsolat.CreateCommand();
                if (role == "rendszer_admin")
                {
                    // 🔹 minden jármű + cégnév
                    parancs.CommandText = @"
                SELECT j.rendszam, c.nev
                FROM jarmuvek j
                JOIN cegek c ON j.ceg_id = c.id
                ORDER BY c.nev, j.rendszam
            ";
                }
                else
                {
                    // 🔹 operator + cég admin → csak saját cég
                    parancs.CommandText = @"
                SELECT rendszam
                FROM jarmuvek
                WHERE ceg_id = @cegId
                ORDER BY rendszam
            ";
                    parancs.Parameters.AddWithValue("@cegId", cegId);
                }

                using (var reader = parancs.ExecuteReader())
                {
                    cbbjarmulista.Items.Clear();

                    while (reader.Read())
                    {
                        if (role == "rendszer_admin")
                        {
                            cbbjarmulista.Items.Add(
                                $"{reader.GetString("rendszam")}  |  {reader.GetString("nev")}"
                            );
                            cbbjarmulista.SelectedIndex = 0;
                        }
                        else
                        {
                            cbbjarmulista.Items.Add(reader.GetString("rendszam"));
                            cbbjarmulista.SelectedIndex = 0;
                        }
                    }
                }


            }
        }

        private void BetoltJarmuAdatok(string rendszam)
        {
            MySqlConnectionStringBuilder build = new MySqlConnectionStringBuilder
            {
                Server = "localhost",
                UserID = "root",
                Password = "mysql",
                Database = "tollutdijadatbazis"
            };

            using (MySqlConnection kapcsolat = new MySqlConnection(build.ConnectionString))
            {
                kapcsolat.Open();

                var cmd = kapcsolat.CreateCommand();
                cmd.CommandText = @"
            SELECT 
                j.rendszam,
                j.ceg_id,
                j.tipus,
                j.kategoria,
                j.ossztomeg_kg
            FROM jarmuvek j
            WHERE j.rendszam = @rendszam
        ";
                cmd.Parameters.AddWithValue("@rendszam", rendszam);

                using (var reader = cmd.ExecuteReader())
                {
                    if (reader.Read())
                    {
                        txbrendszam.Text = reader.GetString("rendszam");
                        txbtipus.Text = reader.GetString("tipus");
                        txbkategoria.Text = reader.GetString("kategoria");
                        txbtomeg.Text = reader.GetInt32("ossztomeg_kg") + " kg";
                        txbcegid.Text = reader.GetInt32("ceg_id").ToString();
                    }
                }
            }
        }

        

        private void btnvissza_Click(object sender, EventArgs e)
        {
           this.Close();
        }

        private void cbbjarmulista_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (cbbjarmulista.SelectedItem == null)
                return;

            string selectedText = cbbjarmulista.SelectedItem.ToString();

            // Ha "ABC-123 | Cég" formátumú
            string rendszam = selectedText.Split('|')[0].Trim();

            BetoltJarmuAdatok(rendszam);
        }

        private void btnmentes_Click(object sender, EventArgs e)
        {

            if (!int.TryParse(txbtomeg.Text.Replace("kg", "").Trim(), out int tomeg))
            {
               
                MessageBox.Show("Hibás össztömeg érték!");
                
                return;
            }

            MySqlConnectionStringBuilder build = new MySqlConnectionStringBuilder
            {
                Server = "localhost",
                UserID = "root",
                Password = "mysql",
                Database = "tollutdijadatbazis"
            };


            using (MySqlConnection kapcsolat = new MySqlConnection(build.ConnectionString))
            {
                try
                {
                    kapcsolat.Open();
                }
                catch
                {
                    MessageBox.Show("Nem sikerült csatlakozni az adatbázishoz.");
                    return;
                }

                var parancs = kapcsolat.CreateCommand();
                parancs.CommandText = @"
                    UPDATE jarmuvek
                    SET 
                        tipus = @tipus,
                        kategoria = @kategoria,
                        ossztomeg_kg = @tomeg
                    WHERE rendszam = @rendszam
                ";

                parancs.Parameters.AddWithValue("@tipus", txbtipus.Text.Trim());
                parancs.Parameters.AddWithValue("@kategoria", txbkategoria.Text.Trim());
                parancs.Parameters.AddWithValue("@tomeg", tomeg);
                parancs.Parameters.AddWithValue("@rendszam", txbrendszam.Text.Trim());
                
                try
                {
                    parancs.ExecuteNonQuery();
                    MessageBox.Show("Sikeres mentés!");
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Hiba mentés közben:\n" + ex.Message);
                }
            }

        }
    }
}
