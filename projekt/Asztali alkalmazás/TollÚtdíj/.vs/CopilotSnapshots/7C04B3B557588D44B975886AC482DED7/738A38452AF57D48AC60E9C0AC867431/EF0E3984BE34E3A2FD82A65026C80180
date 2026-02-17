using MySqlConnector;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics.Eventing.Reader;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using static TollÚtdíj.Login;

namespace TollÚtdíj
{
    public partial class jarmukezeles : Form
    {
        bool hozzaadas = false;
        private readonly string role;
        private readonly int cegId;
        public jarmukezeles(string role, int cegId)
        {
            InitializeComponent();
            txbvin.MaxLength = 17;
            txbvin.CharacterCasing = CharacterCasing.Upper;


            this.role = role;
            this.cegId = cegId;
            lblcegid.Visible = false;
            txbcegid.Visible = false;
            cbbjarmulista.DropDownStyle = ComboBoxStyle.DropDownList;
            cbbeuro.DropDownStyle = ComboBoxStyle.DropDownList;
            cbbpotkocsi.DropDownStyle = ComboBoxStyle.DropDownList;
            cbbeuro.Items.AddRange(new object[] { "EURO 4", "EURO 5", "EURO 6" });
            cbbpotkocsi.Items.AddRange(new object[] { "Nem", "Igen" });

            if (role == "operator")
            {
                this.Text = "Jármű kezelés - Operátor";
                
                txbrendszam.ReadOnly = true;

               
                btnhozzaadas.Enabled = false;
                btnmentes.Enabled = false;

    
                txbtipus.ReadOnly = true;
                txbkategoria.ReadOnly = true;
                txbtengely.ReadOnly = true;
                txbtomeg.ReadOnly = true;
                txbmarka.ReadOnly = true;
                txbvin.ReadOnly = true;
                cbbeuro.Enabled = false;
                cbbpotkocsi.Enabled = false;
            }
            else if (role == "ceg_admin")
            {
                this.Text = "Jármű kezelés - Adminisztrátor";
                txbrendszam.ReadOnly = true;

            }
            else if (role == "rendszer_admin")
            {
                this.Text = "Jármű kezelés - Rendszer adminisztrátor";
                lblcegid.Visible = true;
                txbcegid.Visible = true;
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
                    // mindent kiir
                    parancs.CommandText = @"
                SELECT j.rendszam, c.nev
                FROM jarmuvek j
                JOIN cegek c ON j.ceg_id = c.id
                ORDER BY c.nev, j.rendszam
            ";
                }
                else
                {
                    // csak sajat ceget ir ki
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

                var parancs = kapcsolat.CreateCommand();
                parancs.CommandText = @"
            SELECT 
                j.rendszam,
                j.ceg_id,
                j.tipus,
                j.kategoria,
                j.ossztomeg_kg,
                j.euro_besorolas,
                j.marka,
                j.tengelyszam,
                j.vin,
                j.potkocsi_kepes    
            FROM jarmuvek j
            WHERE j.rendszam = @rendszam
        ";
                parancs.Parameters.AddWithValue("@rendszam", rendszam);

                using (var reader = parancs.ExecuteReader())
                {
                    if (reader.Read())
                    {
                        txbrendszam.Text = reader.GetString("rendszam");
                        txbtipus.Text = reader.GetString("tipus");
                        txbkategoria.Text = reader.GetString("kategoria");
                        txbtomeg.Text = reader.GetInt32("ossztomeg_kg") + "kg";
                        txbcegid.Text = reader.GetInt32("ceg_id").ToString();
                        txbmarka.Text = reader.GetString("marka").ToString();
                        string euro = reader.GetString("euro_besorolas");
                        cbbeuro.SelectedItem = euro;
                        txbtengely.SelectedText = reader.GetInt32("tengelyszam").ToString();
                        txbvin.Text = reader["vin"].ToString();
                        cbbpotkocsi.SelectedIndex = Convert.ToInt32(reader["potkocsi_kepes"]);
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

            
            string rendszam = selectedText.Split('|')[0].Trim();

            BetoltJarmuAdatok(rendszam);
        }

        private void btnmentes_Click(object sender, EventArgs e)
        {
            if (hozzaadas == false)
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
        ossztomeg_kg = @tomeg,
        vin = @vin,
        potkocsi_kepes = @potkocsi,
        marka = @marka,
        euro_besorolas = @euro_besorolas,
        tengelyszam = @tengelyszam
    WHERE rendszam = @rendszam
";


                    parancs.Parameters.AddWithValue("@tipus", txbtipus.Text.Trim());
                parancs.Parameters.AddWithValue("@kategoria", txbkategoria.Text.Trim());
                parancs.Parameters.AddWithValue("@tomeg", tomeg);
                parancs.Parameters.AddWithValue("@rendszam", txbrendszam.Text.Trim());
                    parancs.Parameters.AddWithValue("@vin", txbvin.Text.Trim());
                    int potkocsiKepes = (cbbpotkocsi.SelectedItem?.ToString() == "Igen") ? 1 : 0;
                    parancs.Parameters.AddWithValue("@potkocsi", potkocsiKepes);
                    parancs.Parameters.AddWithValue("@euro_besorolas", cbbeuro.Text);
                    parancs.Parameters.AddWithValue("@tengelyszam", txbtengely.Text.Trim());
                    parancs.Parameters.AddWithValue("@marka", txbmarka.Text.Trim());
                    


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
            else
            {
                {
                    if (!int.TryParse(txbtomeg.Text, out int tomeg) ||
                        !int.TryParse(txbtengely.Text, out int tengely))
                    {
                        MessageBox.Show("Hibás számérték!");
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
                        kapcsolat.Open();

                        var parancs = kapcsolat.CreateCommand();
                        parancs.CommandText = @"
    INSERT INTO jarmuvek
    (rendszam, ceg_id, kategoria, marka, tipus, tengelyszam, euro_besorolas, ossztomeg_kg, vin, potkocsi_kepes, aktiv)
    VALUES
    (@r, @ceg, @kat, @marka, @tip, @ten, @euro, @tomeg, @vin, @potkocsi, 1)
";

                        parancs.Parameters.AddWithValue("@r", txbrendszam.Text.Trim());
                        parancs.Parameters.AddWithValue("@kat", txbkategoria.Text.Trim());
                        parancs.Parameters.AddWithValue("@marka", txbmarka.Text.Trim());
                        parancs.Parameters.AddWithValue("@tip", txbtipus.Text.Trim());
                        parancs.Parameters.AddWithValue("@ten", tengely);
                        parancs.Parameters.AddWithValue("@euro", cbbeuro.Text);
                        parancs.Parameters.AddWithValue("@tomeg", tomeg);
                        parancs.Parameters.AddWithValue("@vin", txbvin.Text.Trim());
                        int potkocsiKepes = (cbbpotkocsi.SelectedItem?.ToString() == "Igen") ? 1 : 0;
                        parancs.Parameters.AddWithValue("@potkocsi", potkocsiKepes);

                        int insertCegId = role == "rendszer_admin" ? int.Parse(txbcegid.Text) : cegId;
                        parancs.Parameters.AddWithValue("@ceg", insertCegId);
                        parancs.ExecuteNonQuery();

                        MessageBox.Show("Új jármű sikeresen hozzáadva!");

                        hozzaadas = false;
                        btnhozzaadas.Text = "Új jármű";
                        btnmentes.Text = "Mentés";
                        cbbjarmulista.Enabled = true;

                        jarmukezeles_Load(null, null); 
                    }
                }
            }
    }
        
        

        private void btnhozzaadas_Click(object sender, EventArgs e)
        {
            hozzaadas = !hozzaadas;

            if (hozzaadas)
            {
                btnhozzaadas.Text = "Mégse";
                btnmentes.Text = "Új mentése";

                txbrendszam.Clear();
                txbmarka.Clear();
                txbtipus.Clear();
                txbkategoria.Clear();
                txbtengely.Clear();
                txbtomeg.Clear();
                cbbeuro.SelectedIndex = -1;
                txbvin.Clear();
                cbbpotkocsi.SelectedIndex = 0;

                if (role == "rendszer_admin")
                    txbcegid.Clear();

                txbrendszam.ReadOnly = false;
                cbbjarmulista.Enabled = false;
            }
            else
            {
                btnhozzaadas.Text = "Új jármű";
                btnmentes.Text = "Mentés";

                txbrendszam.ReadOnly = true;
                cbbjarmulista.Enabled = true;

                if (cbbjarmulista.SelectedItem != null)
                {
                    string r = cbbjarmulista.Text.Split('|')[0].Trim();
                    BetoltJarmuAdatok(r);
                }
            }
        }
        private string KivalasztottJarmuNev()
        {
            if (cbbjarmulista.SelectedItem == null)
                return null;

            string szoveg = cbbjarmulista.Text;

            // ha rendszeradmin = "nev | ceg"
            if (role == "rendszer_admin" && szoveg.Contains("|"))
                return szoveg.Split('|')[0].Trim();


            return szoveg.Trim();
        }
        private void btntorles_Click(object sender, EventArgs e)
        {
            DialogResult valasz = MessageBox.Show(
    "Biztosan törölni szeretné a kijelölt járművet?\nEz a művelet nem visszavonható!",
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
        DELETE FROM jarmuvek
        WHERE rendszam = @rendszam
    ";

                string jarmuNev = KivalasztottJarmuNev();
                if (jarmuNev == null)
                    return;

                parancs.Parameters.AddWithValue("@rendszam", jarmuNev);

                try
                {
                    parancs.ExecuteNonQuery();
                    MessageBox.Show("Jármű sikeresen törölve.");
                }
                catch (Exception ex)
                {
                    lblhiba.Text = "Hiba törlés közben:\n" + ex.Message;
                    lblhiba.Visible = true;
                    return;
                }
            }
            cbbjarmulista.Items.Remove(cbbjarmulista.SelectedItem);

            if (cbbjarmulista.Items.Count > 0)
                cbbjarmulista.SelectedIndex = 0;
        }
    }
    
}
