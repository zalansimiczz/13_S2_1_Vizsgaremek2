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
    public partial class soforkezeles : Form
    {
        private readonly string role;
        private readonly int cegId;
        bool hozzaadas = false;
        


        public soforkezeles(string role, int cegId)
        {
            InitializeComponent();
            cbbaktiv.Items.AddRange(new object[] { "Igen", "Nem" });
            cbbaktiv.DropDownStyle = ComboBoxStyle.DropDownList;
            this.role = role;
            this.cegId = cegId;
            lblhiba.Visible = false;
            txbnev.Enabled = false;
            cbbsoforlista.DropDownStyle = ComboBoxStyle.DropDownList;
            if (role == "operator")
            {
                this.Text = "Sofőr kezelés - Operátor";
            }
            else if (role == "ceg_admin")
            {
                this.Text = "Sofőr kezelés - Adminisztrátor";

            }
            else if (role == "rendszer_admin")
            {
                this.Text = "Sofőr - Rendszer adminisztrátor";
                txbnev.Enabled = true;
            }
        }

        private void soforkezeles_Load(object sender, EventArgs e)
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
                catch
                {
                    lblhiba.Text = "Adatbetöltési hiba.\r\nEllenőrizze az internetkapcsolatot.";
                    lblhiba.Visible = true;
                    return;
                }

                var parancs = kapcsolat.CreateCommand();

                if (role == "rendszer_admin")
                {
                    parancs.CommandText = @"
                SELECT a.nev, c.nev AS ceg_nev
                FROM soforok a
                JOIN cegek c ON a.ceg_id = c.id
                ORDER BY c.nev, a.nev";
                }
                else
                {
                    parancs.CommandText = @"
                SELECT nev
                FROM soforok
                WHERE ceg_id = @cegId
                ORDER BY nev";

                    parancs.Parameters.AddWithValue("@cegId", cegId);
                }

                using (var reader = parancs.ExecuteReader())
                {
                    cbbsoforlista.Items.Clear();

                    while (reader.Read())
                    {
                        if (role == "rendszer_admin")
                        {
                            cbbsoforlista.Items.Add(
                                $"{reader.GetString("nev")} | {reader.GetString("ceg_nev")}"
                            );
                            cbbsoforlista.SelectedIndex = 0;
                        }
                        else
                        {
                            cbbsoforlista.Items.Add(reader.GetString("nev"));
                            cbbsoforlista.SelectedIndex = 0;
                        }
                    }

                   
                }
            }
        }

        private void BetoltSoforAdatok(string sofor)
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
                parancs.CommandText = @"
            SELECT 
                s.nev,
                s.ceg_id,
                s.szemelyi_azonosito,
                s.szuletesi_datum,
                s.telefonszam,
                s.adoszam,
                s.cim,
                s.aktiv
            FROM soforok s
            WHERE s.nev = @sofor
        ";
                parancs.Parameters.AddWithValue("@sofor", sofor);

                using (var reader = parancs.ExecuteReader())
                {
                    if (reader.Read())
                    {
                        txbnev.Text = reader.GetString("nev").ToString();
                        txbszul.Text = reader.GetDateTime("szuletesi_datum").ToString("yyyy MM dd");
                        txbszemazon.Text = reader.GetString("szemelyi_azonosito");
                        txbtelszam.Text = reader.GetString("telefonszam");
                        txbcim.Text = reader.GetString("cim");
                        txbcegid.Text = reader.GetInt32("ceg_id").ToString();
                        int aktiv = reader.GetInt32("aktiv");
                        cbbaktiv.SelectedItem = aktiv == 1 ? "Igen" : "Nem";
                        txbadoszam.Text = reader.GetString("adoszam");
                        
                    }
                }
            }

        }
        private void btnvissza_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void cbbsoforlista_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (cbbsoforlista.SelectedItem == null)
                return;

            string sofor = cbbsoforlista.Text.Split('|')[0].Trim();

            BetoltSoforAdatok(sofor);
        }

        private void btnhozzaadas_Click(object sender, EventArgs e)
        {
            hozzaadas = !hozzaadas;

            if (hozzaadas)
            {
                btnhozzaadas.Text = "Mégse";
                btnmentes.Text = "Új mentése";
                cbbaktiv.SelectedIndex = 0;
                txbszul.Clear();
                txbszemazon.Clear();
                txbtelszam.Clear();
                txbcim.Clear();
                txbadoszam.Clear();
                txbnev.Clear();
                txbnev.ReadOnly = false;
                txbnev.Enabled = true;
                if (role == "rendszer_admin")
                    txbcegid.Clear();

                
                cbbsoforlista.Enabled = false;
            }
            else
            {
                btnhozzaadas.Text = "Új sofőr";
                btnmentes.Text = "Mentés";


                cbbsoforlista.Enabled = true;

                if (cbbsoforlista.SelectedItem != null)
                {
                    string r = cbbsoforlista.Text;
                    BetoltSoforAdatok(r);
                }
            }
        }

        private void btnmentes_Click(object sender, EventArgs e)
        {
            if (hozzaadas == false)
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
                    catch
                    {
                        lblhiba.Text = "Adatbetöltési hiba.\r\nEllenőrizze az internetkapcsolatot, majd próbálja újra.";
                        lblhiba.Visible = true;
                        return;
                    }

                    var parancs = kapcsolat.CreateCommand();

                    parancs.CommandText = @"
                UPDATE soforok
                SET
                    nev = @ujnev,
                    szemelyi_azonosito = @szemazon,
                    szuletesi_datum = @szul,
                    telefonszam = @tel,
                    cim = @cim,
                    adoszam = @adoszam,
                    aktiv = @aktiv
                WHERE nev = @nev
            ";

                    parancs.Parameters.AddWithValue("@nev", cbbsoforlista.Text.Trim());
                    parancs.Parameters.AddWithValue("@ceg", txbcegid.Text.Trim());
                    parancs.Parameters.AddWithValue("@ujnev", txbnev.Text.Trim());

                    parancs.Parameters.AddWithValue("@szemazon", txbszemazon.Text.Trim());
                    parancs.Parameters.AddWithValue("@szul", DateTime.Parse(txbszul.Text));
                    parancs.Parameters.AddWithValue("@tel", txbtelszam.Text.Trim());
                    parancs.Parameters.AddWithValue("@cim", txbcim.Text.Trim());
                    parancs.Parameters.AddWithValue("@adoszam", txbadoszam.Text.Trim());
                    int aktiv = cbbaktiv.SelectedItem.ToString() == "Igen" ? 1 : 0;
                    parancs.Parameters.AddWithValue("@aktiv", aktiv);



                    try
                    {
                        parancs.ExecuteNonQuery();
                        MessageBox.Show("Sikeres mentés!");
                    }
                    catch (Exception ex)
                    {
                        lblhiba.Text = "Hiba mentés közben:\n" + ex.Message;
                        lblhiba.Visible = true;
                        return;
                    }
                }
            }
            else
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
                    catch
                    {
                        lblhiba.Text = "Adatbetöltési hiba.\r\nEllenőrizze az internetkapcsolatot, majd próbálja újra.";
                        lblhiba.Visible = true;
                        return;
                    }
                    var parancs = kapcsolat.CreateCommand();

                    parancs.CommandText = @"
                INSERT INTO soforok
                (nev, ceg_id, szemelyi_azonosito, szuletesi_datum, telefonszam, cim, adoszam, aktiv)
                VALUES
                (@nev, @ceg, @szemazon, @szul, @tel, @cim, @adoszam, @aktiv)
            ";

                    int insertCegId = role == "rendszer_admin"
                        ? int.Parse(txbcegid.Text)
                        : cegId;

                    parancs.Parameters.AddWithValue("@nev", txbnev.Text.Trim());
                    parancs.Parameters.AddWithValue("@ceg", insertCegId);

                    parancs.Parameters.AddWithValue("@szemazon", txbszemazon.Text.Trim());
                    parancs.Parameters.AddWithValue("@szul", DateTime.Parse(txbszul.Text));
                    parancs.Parameters.AddWithValue("@tel", txbtelszam.Text.Trim());
                    parancs.Parameters.AddWithValue("@cim", txbcim.Text.Trim());
                    parancs.Parameters.AddWithValue("@adoszam", txbadoszam.Text.Trim());
                    int aktiv = cbbaktiv.SelectedItem.ToString() == "Igen" ? 1 : 0;
                    parancs.Parameters.AddWithValue("@aktiv", aktiv);

                    try
                    {
                        parancs.ExecuteNonQuery();
                        MessageBox.Show("Sikeres mentés!");
                    }
                    catch (Exception ex)
                    {
                        lblhiba.Text = "Hiba mentés közben:\n" + ex.Message;
                        lblhiba.Visible = true;
                        return;
                    }
                }



            }
        }

            

        private void btntorles_Click(object sender, EventArgs e)
        {
            DialogResult valasz = MessageBox.Show(
    "Biztosan törölni szeretné a kijelölt sofőrt?\nEz a művelet nem visszavonható!",
    "Megerősítés",
    MessageBoxButtons.YesNo,
    MessageBoxIcon.Warning
);

            if (valasz != DialogResult.Yes)
                return;

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
                    lblhiba.Text = "Adatbázis kapcsolat hiba.";
                    lblhiba.Visible = true;
                    return;
                }

                var parancs = kapcsolat.CreateCommand();
                parancs.CommandText = @"
        DELETE FROM soforok
        WHERE nev = @nev
    ";

                parancs.Parameters.AddWithValue("@nev", cbbsoforlista.Text.Trim());

                try
                {
                    parancs.ExecuteNonQuery();
                    MessageBox.Show("Sofőr sikeresen törölve.");
                }
                catch (Exception ex)
                {
                    lblhiba.Text = "Hiba törlés közben:\n" + ex.Message;
                    lblhiba.Visible = true;
                    return;
                }
            }
            cbbsoforlista.Items.Remove(cbbsoforlista.SelectedItem);

            if (cbbsoforlista.Items.Count > 0)
                cbbsoforlista.SelectedIndex = 0;
        }
    }
    }

