import cv2
import os
import numpy as np
import matplotlib.pyplot as plt
import pyttsx3
import random
import pickle
import tensorflow as tf
from skimage.transform import resize
from sklearn.model_selection import train_test_split
from tensorflow.keras.utils import to_categorical
from tensorflow.keras.models import load_model, Sequential
from tensorflow.keras.layers import Dense, Flatten, Conv2D, MaxPooling2D
import winsound
import time
from flask import Flask, render_template, Response, redirect, request

cap = cv2.VideoCapture(0)

##################################################### Flask ############################################

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html') 

##################################################### View Camera ######################################
@app.route('/video_feed')
def video_feed():
    return Response(camera(), mimetype='multipart/x-mixed-replace; boundary=frame')

def camera():
    
    while(True):
        ret, frame = cap.read()
        if ret == True:
            start_point = (425, 100)
            end_point = (625, 300)
            color = (0, 100, 255)

            gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
            gray_flip = cv2.flip(gray, 1)

            img = cv2.rectangle(gray_flip, start_point, end_point,color, thickness=2, lineType=8)
            fullimg = cv2.rectangle(cv2.flip(frame, 1), start_point, end_point,color, thickness=2, lineType=8)
            
            imcrop = img[102:298, 427:623]

            (thresd, binaryimg) = cv2.threshold(imcrop, 127, 255, cv2.THRESH_BINARY)

          

            frame = cv2.imencode('.jpg', fullimg)[1].tobytes()
            yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
            time.sleep(0.05)

        else: 
            break

##################################################### View Camera Color ######################################
@app.route('/video_feed_colorcrop')
def video_feed_colorcrop():
    return Response(cameracolor(), mimetype='multipart/x-mixed-replace; boundary=frame')

def cameracolor():
    
    while(True):
        ret, frame = cap.read()
        if ret == True:
            start_point = (425, 100)
            end_point = (625, 300)
            color = (0, 100, 255)

            gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
            gray_flip = cv2.flip(gray, 1)

            img = cv2.rectangle(gray_flip, start_point, end_point,color, thickness=2, lineType=8)
            fullimg = cv2.rectangle(cv2.flip(frame, 1), start_point, end_point,color, thickness=2, lineType=8)
            
            imcrop = img[102:298, 427:623]

            fullimgcrop = fullimg[102:298, 427:623]
            cv2.imshow('fullimgcrop',fullimgcrop)

            (thresd, binaryimg) = cv2.threshold(imcrop, 127, 255, cv2.THRESH_BINARY)

           
            frame = cv2.imencode('.jpg', fullimgcrop)[1].tobytes()
            yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
            time.sleep(0.05)

        else: 
            break



#################################################### Path image ##############################################################3
@app.route('/recg_single_img', methods=['GET', 'POST'])
def recg_single_img():

    print("Called recg_single_img")
    imgpath = request.form['imgpath']
    print(imgpath)
    

    try:
        s=imgpath.replace("\\","/")
        recimg = cv2.imread(s)
        IMG_SIZE = 100
        print("Recg please wait")
        BASE_DIR=os.getcwd()
        dataset_dir=os.path.join(BASE_DIR,"Dataset")
        categories=os.listdir(dataset_dir)
        # print(dataset_dir,"\n",categories)

            
        model = load_model('savedmodel')
        my_image_resized = resize(recimg, (IMG_SIZE,IMG_SIZE,1))
        probabilities = model.predict(np.array( [my_image_resized,] ))

        index = np.argsort(probabilities[0,:])
        category = categories[index[len(categories)-1]]
        probability = probabilities[0,index[len(categories)-1]]*100
        print("\n\n\n Predicted Class:", category,"\n Probability:", probability)

        return render_template('index.html',sentence=category)

    except:
        print("There is no Dataset")
        category = "There is no Dataset"
        print(category)
        
    return render_template('index.html',sentence=category)



##################################################### Recognisation #################################################################
@app.route('/recognisation')
def recognisation():
    sentence = " "
    pervious = " "

    BASE_DIR=os.getcwd()
    dataset_dir=os.path.join(BASE_DIR,"Dataset")
    categories=os.listdir(dataset_dir)
    print(dataset_dir,"\n",categories)

    IMG_SIZE = 100
    
    model = load_model('savedmodel')
    model.summary()
   
    while(True):
        ret, frame = cap.read()

        start_point = (425, 100)
        end_point = (625, 300)
        color = (0, 100, 255)

        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        gray_flip = cv2.flip(gray, 1)

        img = cv2.rectangle(gray_flip, start_point, end_point,color, thickness=2, lineType=8)
        fullimg = cv2.rectangle(cv2.flip(frame, 1), start_point, end_point,color, thickness=2, lineType=8)
        
        imcrop = img[102:298, 427:623]

        (thresd, binaryimg) = cv2.threshold(imcrop, 127, 255, cv2.THRESH_BINARY)



        fullimgcrop = fullimg[102:298, 427:623]
        cv2.imshow('fullimgcrop',fullimgcrop)

        my_image_resized = resize(fullimgcrop, (IMG_SIZE,IMG_SIZE,1)) 

        probabilities = model.predict(np.array( [my_image_resized,] ))

        index = np.argsort(probabilities[0,:])
        category = categories[index[len(categories)-1]]
        probability = probabilities[0,index[len(categories)-1]]*100
        print("\n\n\n Predicted Class:", category,"\n Probability:", probability)

        if pervious != category:
            sentence += " "
            sentence += category
            pervious = category

        
        print(sentence)
        
        return render_template('index.html',sentence=sentence)


if __name__ == "__main__":
    app.run()