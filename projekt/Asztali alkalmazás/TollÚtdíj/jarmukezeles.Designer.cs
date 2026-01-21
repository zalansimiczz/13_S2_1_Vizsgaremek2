namespace TollÚtdíj
{
    partial class jarmukezeles
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.btnvissza = new System.Windows.Forms.Button();
            this.lblhiba = new System.Windows.Forms.Label();
            this.lbladatok = new System.Windows.Forms.Label();
            this.txbkategoria = new System.Windows.Forms.TextBox();
            this.txbtipus = new System.Windows.Forms.TextBox();
            this.txbrendszam = new System.Windows.Forms.TextBox();
            this.btnmentes = new System.Windows.Forms.Button();
            this.txbtomeg = new System.Windows.Forms.TextBox();
            this.txbcegid = new System.Windows.Forms.TextBox();
            this.lblcegid = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.lbl1 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.cbbjarmulista = new System.Windows.Forms.ComboBox();
            this.btnhozzaadas = new System.Windows.Forms.Button();
            this.label4 = new System.Windows.Forms.Label();
            this.SuspendLayout();
            // 
            // btnvissza
            // 
            this.btnvissza.Location = new System.Drawing.Point(12, 12);
            this.btnvissza.Name = "btnvissza";
            this.btnvissza.Size = new System.Drawing.Size(75, 23);
            this.btnvissza.TabIndex = 0;
            this.btnvissza.Text = "Vissza";
            this.btnvissza.UseVisualStyleBackColor = true;
            this.btnvissza.Click += new System.EventHandler(this.btnvissza_Click);
            // 
            // lblhiba
            // 
            this.lblhiba.AutoSize = true;
            this.lblhiba.ForeColor = System.Drawing.Color.Red;
            this.lblhiba.Location = new System.Drawing.Point(12, 418);
            this.lblhiba.Name = "lblhiba";
            this.lblhiba.Size = new System.Drawing.Size(35, 13);
            this.lblhiba.TabIndex = 3;
            this.lblhiba.Text = "label1";
            this.lblhiba.Visible = false;
            // 
            // lbladatok
            // 
            this.lbladatok.AutoSize = true;
            this.lbladatok.Location = new System.Drawing.Point(191, 90);
            this.lbladatok.Name = "lbladatok";
            this.lbladatok.Size = new System.Drawing.Size(44, 13);
            this.lbladatok.TabIndex = 12;
            this.lbladatok.Text = "Adatok:";
            // 
            // txbkategoria
            // 
            this.txbkategoria.Location = new System.Drawing.Point(153, 198);
            this.txbkategoria.Name = "txbkategoria";
            this.txbkategoria.Size = new System.Drawing.Size(134, 20);
            this.txbkategoria.TabIndex = 11;
            // 
            // txbtipus
            // 
            this.txbtipus.Location = new System.Drawing.Point(153, 157);
            this.txbtipus.Name = "txbtipus";
            this.txbtipus.Size = new System.Drawing.Size(134, 20);
            this.txbtipus.TabIndex = 10;
            // 
            // txbrendszam
            // 
            this.txbrendszam.Location = new System.Drawing.Point(153, 116);
            this.txbrendszam.Name = "txbrendszam";
            this.txbrendszam.Size = new System.Drawing.Size(134, 20);
            this.txbrendszam.TabIndex = 9;
            // 
            // btnmentes
            // 
            this.btnmentes.Location = new System.Drawing.Point(167, 277);
            this.btnmentes.Name = "btnmentes";
            this.btnmentes.Size = new System.Drawing.Size(101, 38);
            this.btnmentes.TabIndex = 8;
            this.btnmentes.Text = "Változtatások mentése";
            this.btnmentes.UseVisualStyleBackColor = true;
            this.btnmentes.Click += new System.EventHandler(this.btnmentes_Click);
            // 
            // txbtomeg
            // 
            this.txbtomeg.Location = new System.Drawing.Point(153, 237);
            this.txbtomeg.Name = "txbtomeg";
            this.txbtomeg.Size = new System.Drawing.Size(134, 20);
            this.txbtomeg.TabIndex = 13;
            // 
            // txbcegid
            // 
            this.txbcegid.Location = new System.Drawing.Point(153, 341);
            this.txbcegid.Name = "txbcegid";
            this.txbcegid.Size = new System.Drawing.Size(134, 20);
            this.txbcegid.TabIndex = 14;
            // 
            // lblcegid
            // 
            this.lblcegid.AutoSize = true;
            this.lblcegid.Location = new System.Drawing.Point(182, 325);
            this.lblcegid.Name = "lblcegid";
            this.lblcegid.Size = new System.Drawing.Size(79, 13);
            this.lblcegid.TabIndex = 15;
            this.lblcegid.Text = "Cég azonosító:";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(90, 201);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(55, 13);
            this.label2.TabIndex = 18;
            this.label2.Text = "Kategória:";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(107, 157);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(38, 13);
            this.label1.TabIndex = 17;
            this.label1.Text = "Típus:";
            // 
            // lbl1
            // 
            this.lbl1.AutoSize = true;
            this.lbl1.Location = new System.Drawing.Point(85, 119);
            this.lbl1.Name = "lbl1";
            this.lbl1.Size = new System.Drawing.Size(60, 13);
            this.lbl1.TabIndex = 16;
            this.lbl1.Text = "Rendszám:";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(83, 240);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(62, 13);
            this.label3.TabIndex = 19;
            this.label3.Text = "Össztömeg:";
            // 
            // cbbjarmulista
            // 
            this.cbbjarmulista.FormattingEnabled = true;
            this.cbbjarmulista.Location = new System.Drawing.Point(140, 57);
            this.cbbjarmulista.Name = "cbbjarmulista";
            this.cbbjarmulista.Size = new System.Drawing.Size(152, 21);
            this.cbbjarmulista.TabIndex = 20;
            this.cbbjarmulista.SelectedIndexChanged += new System.EventHandler(this.cbbjarmulista_SelectedIndexChanged);
            // 
            // btnhozzaadas
            // 
            this.btnhozzaadas.Location = new System.Drawing.Point(305, 398);
            this.btnhozzaadas.Name = "btnhozzaadas";
            this.btnhozzaadas.Size = new System.Drawing.Size(133, 33);
            this.btnhozzaadas.TabIndex = 21;
            this.btnhozzaadas.Text = "Új jármű hozzáadása";
            this.btnhozzaadas.UseVisualStyleBackColor = true;
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(164, 41);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(97, 13);
            this.label4.TabIndex = 22;
            this.label4.Text = "Jelenlegi járművek:";
            // 
            // jarmukezeles
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(450, 440);
            this.Controls.Add(this.label4);
            this.Controls.Add(this.btnhozzaadas);
            this.Controls.Add(this.cbbjarmulista);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.lbl1);
            this.Controls.Add(this.lblcegid);
            this.Controls.Add(this.txbcegid);
            this.Controls.Add(this.txbtomeg);
            this.Controls.Add(this.lbladatok);
            this.Controls.Add(this.txbkategoria);
            this.Controls.Add(this.txbtipus);
            this.Controls.Add(this.txbrendszam);
            this.Controls.Add(this.btnmentes);
            this.Controls.Add(this.lblhiba);
            this.Controls.Add(this.btnvissza);
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "jarmukezeles";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "jarmukezeles";
            this.Load += new System.EventHandler(this.jarmukezeles_Load);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button btnvissza;
        private System.Windows.Forms.Label lblhiba;
        private System.Windows.Forms.Label lbladatok;
        private System.Windows.Forms.TextBox txbkategoria;
        private System.Windows.Forms.TextBox txbtipus;
        private System.Windows.Forms.TextBox txbrendszam;
        private System.Windows.Forms.Button btnmentes;
        private System.Windows.Forms.TextBox txbtomeg;
        private System.Windows.Forms.TextBox txbcegid;
        private System.Windows.Forms.Label lblcegid;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label lbl1;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.ComboBox cbbjarmulista;
        private System.Windows.Forms.Button btnhozzaadas;
        private System.Windows.Forms.Label label4;
    }
}