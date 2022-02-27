import os
import wave, struct, math, random
from pydub import AudioSegment
from pydub.effects import normalize
from pydub.playback import play
import matplotlib.pyplot as plt
import scipy.io.wavfile
import librosa
import librosa.display
import IPython.display as ipd
from math import log10, floor
from os import path
import numpy as np
from scipy import signal
from scipy.fftpack import fft, ifft,fftfreq
import sys
from scipy.io import wavfile

class filePrep:
    
    userDrop = "userSound/userSound.wav"
    if userDrop.endswith('.mp3'):
        songToCheck = AudioSegment.from_mp3(userDrop)
        songToCheck.export(userDropWav, format="wav")
        userDrop = userDropWav

class getParam:
    
    tempWavSegment = AudioSegment.from_wav(filePrep.userDrop)
    def getSongData(x): #Getting the song data
        songDataTable = []

        sampleWidth = x.sample_width
        songDataTable.append(sampleWidth)

        sampleChannels = x.channels
        songDataTable.append(sampleChannels)
    
        sampleFrameRate = x.frame_rate
        songDataTable.append(sampleFrameRate)

        sampleMaxAmp = x.max
        songDataTable.append(sampleMaxAmp)

        sampleDuration = (len(x)*0.001)/60
        songDataTable.append(sampleDuration)

        return songDataTable
    
    songDataOutput = getSongData(tempWavSegment)

class getGraphs:
    def getSongGraphs(z):
        a, sr = librosa.load(z, sr=44100)
 
        #print(type(a), type(sr))
        #print(a.shape, sr)

        plt.figure(figsize=(14, 5))
        librosa.display.waveplot(a, sr=sr)
        plt.savefig('graph1.png')

        A = librosa.stft(a)
        Adb = librosa.amplitude_to_db(abs(A))
        plt.figure(figsize=(14, 5))
        librosa.display.specshow(Adb, sr=sr, x_axis='time', y_axis='hz')
        plt.colorbar()

        plt.savefig('graph2.png')
    
    songGraphs = getSongGraphs(filePrep.userDrop)

class maxData:

    def getMaxData(y):
        frate,data = wavfile.read(y)
        #print(frate)

        #Discrete Fourier Transform
        w = np.fft.fft(data)
        freqs = np.fft.fftfreq(len(w))

        #Getting data of the width of peak
        idx = np.argmax(np.abs(w))

        ##print(idx)
        ##print(freqs)

        #simplifying the data
        listOfFreqs = []
        counter = 0
        for x in freqs:
            counter += 1
            if counter % 800 == 0:
                listOfFreqs.append(round(x, 1))

        return listOfFreqs, idx

    songMaxData = getMaxData(filePrep.userDrop)[0]
    songTransposeIdentifier = getMaxData(filePrep.userDrop)[1]

class fingerPrint:
    def fingerPrint(b):
        bElement = b[::2]
        sumOf2nd = int(round((sum(bElement) * 10),1))
        sumOf2nd = str(sumOf2nd)
    
        listOfMod = []
        for num in b:
            listOfMod.append(num % 2)
        listOfModSum = int(round(sum(listOfMod),0))
        listOfModSum = str(listOfModSum)
    
        val5Hex = str(hex(int(round((sum(bElement) * 10),1))))

        fileString1 = sumOf2nd,listOfModSum,val5Hex
        fileFingerprint = "".join(fileString1)

        return(fileFingerprint)
    

    result = fingerPrint(maxData.songMaxData)
    f = open('fingerPrint.txt', 'w')
    print('Data Fingerprint: ',result, file = f)
    g = open('pitchData.txt', 'w')
    print('Pitch of File: ',maxData.songTransposeIdentifier, file = g)