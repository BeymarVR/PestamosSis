from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
from sklearn.linear_model import LogisticRegression
import joblib
import os

app = Flask(__name__)

MODEL_PATH = 'logistic_model.joblib'

# Datos de entrenamiento simulados (Ideales para la primera ejecución)
# En una fase posterior, esto se alimentará de un CSV exportado de Laravel
def train_initial_model():
    # Variables: porcentaje_pagos_a_tiempo, cantidad_moras, antiguedad_dias, prestamos_previos, monto_promedio
    # Target: 1 (Buen pagador), 0 (Riesgo alto)
    data = {
        'porcentaje_pagos_a_tiempo': [100, 90, 50, 20, 100, 80, 10],
        'cantidad_moras': [0, 0, 2, 5, 0, 1, 8],
        'antiguedad_dias': [365, 200, 50, 10, 500, 150, 5],
        'prestamos_previos': [2, 1, 1, 0, 3, 1, 0],
        'monto_promedio': [5000, 2000, 10000, 5000, 1500, 3000, 10000],
        'cumplimiento': [1, 1, 0, 0, 1, 1, 0]
    }
    df = pd.DataFrame(data)
    X = df.drop('cumplimiento', axis=1)
    y = df['cumplimiento']
    
    model = LogisticRegression()
    model.fit(X, y)
    joblib.dump(model, MODEL_PATH)
    return model

if not os.path.exists(MODEL_PATH):
    train_initial_model()

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        
        # Extraer variables enviadas desde Laravel
        features = [
            data.get('porcentaje_pagos_a_tiempo', 0),
            data.get('cantidad_moras', 0),
            data.get('antiguedad_dias', 0),
            data.get('prestamos_previos', 0),
            data.get('monto_promedio', 0)
        ]
        
        model = joblib.load(MODEL_PATH)
        prediction_proba = model.predict_proba([features])[0][1] # Probabilidad de clase 1 (cumplimiento)
        prediction = int(model.predict([features])[0])
        
        # Determinar nivel y recomendaciones
        score = round(prediction_proba * 100)
        if score >= 80:
            nivel = "Excelente"
            recom = ["Aprobación altamente recomendada", "Posibilidad de aumentar monto"]
        elif score >= 60:
            nivel = "Bueno"
            recom = ["Aprobación recomendada", "Verificar garantías"]
        elif score >= 40:
            nivel = "Regular"
            recom = ["Proceder con cautela", "Solicitar más avales"]
        else:
            nivel = "Riesgo Alto"
            recom = ["No se recomienda aprobación", "Revisar historial detallado"]

        return jsonify({
            'score_crediticio': score,
            'nivel': nivel,
            'recomendaciones': recom,
            'probabilidad': prediction_proba
        })
        
    except Exception as e:
        return jsonify({'error': str(e)}), 400

@app.route('/train', methods=['POST'])
def train():
    # Endpoint para re-entrenar con datos reales enviados desde Laravel
    return jsonify({'message': 'Funcionalidad de re-entrenamiento en desarrollo'})

if __name__ == '__main__':
    app.run(port=5000, debug=True)
